<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\traits\apiTraits;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
/**
 * @group Authentication
 *
 * APIs for user registration, login, and logout.
 */
class AuthController extends Controller
{
    use apiTraits;
        /**
     * Register a new user.
     *
     * This endpoint registers a new user and returns a token for authentication.
     *
     * @bodyParam name string required The user's full name. Example: "John Doe"
     * @bodyParam email string required The user's email address. Must be unique. Example: "johndoe@example.com"
     * @bodyParam password string required The user's password. Must be confirmed. Example: "password123"
     * @bodyParam password_confirmation string required Password confirmation. Example: "password123"
     * @bodyParam image file optional A profile image. Only jpg, jpeg, and png formats are allowed.
     * 
     * @response 200 {
     *    "status": true,
     *    "message": "user register successfully",
     *    "data": {
     *        "user": {
     *            "id": 1,
     *            "name": "John Doe",
     *            "email": "johndoe@example.com",
     *            "image": "path/to/image.jpg",
     *            "created_at": "2024-11-17T10:20:30.000Z"
     *        },
     *        "token": "4|AiwkA7Tmt9TtWAs...NkAzjl"
     *    }
     * }
     * @response 500 {
     *    "status": false,
     *    "message": "An error occurred Internal Server Error"
     * }
     */
    public function register(Request $request){
        try {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'image'=>['nullable','mimes:jpg,jpeg,png'],
                'bio' => ['nullable', 'string', 'max:500'],
            ];
            $massage= $this->ReturnValidationError($request,$rules);
            if(isset($massage)){
              return $massage;
            }
            if($request->hasFile('image')){
                //using saveimage method in  savephoto trait 
                $image = $this->SaveImage($request->file('image'),'users\uploads\avaters',600,600)  ;
                // insert new user in database(users table)
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'image'=>$image,
                    'bio'=>$request->bio
    
                        ]);
                }else{
                        $user = User::create([
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                            'bio'=>$request->bio
                            
    
                        ]);
            }
                $token = $user->createToken('API Token')->plainTextToken;
                $value = ['user'=>$user,'token'=>$token];
                return $this->ReturnData('data',$value,"user register successfully");
          } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
          }
      
    }
      /**
     * User login.
     *
     * Authenticates a user and returns a token if credentials are correct.
     *
     * @bodyParam email string required The user's email address. Example: "johndoe@example.com"
     * @bodyParam password string required The user's password. Example: "password123"
     * 
     * @response 200 {
     *    "status": true,
     *    "message": "user login successfully",
     *    "data": {
     *        "user": {
     *            "id": 1,
     *            "name": "John Doe",
     *            "email": "johndoe@example.com"
     *        },
     *        "token": "4|AiwkA7Tmt9TtWAs...NkAzjl"
     *    }
     * }
     * @response 900 {
     *    "status": false,
     *    "message": "The provided credentials are incorrect"
     * }
     * @response 500 {
     *    "status": false,
     *    "message": "An error occurred Internal Server Error"
     * }
     */
    public function login(Request $request){
        try {
            
            $massage= $this->ReturnValidationError($request,['email' => 'required|email','password' => 'required|string|min:8',]);
            if(isset($massage)){
              return $massage;
            }
            $user =User::where('email', $request->email)->first();
    
    
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return $this->ReturnErrorMessage('The provided credentials are incorrect','900');
            }
    
            $token = $user->createToken('API Token')->plainTextToken;
            $value = ['user'=>$user,'token'=>$token];
            return $this->ReturnData('data',$value,"user login successfully");
          } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
          }
        
   
       
    }
      /**
     * User logout.
     *
     * Logs out the authenticated user by revoking the current access token.
     *
     * @authenticated
     * 
     * @response 200 {
     *    "status": true,
     *    "message": "Logged out"
     * }
     * @response 500 {
     *    "status": false,
     *    "message": "An error occurred Internal Server Error"
     * }
     */
    public function logout(Request $request){
        try {
            $token=  $request->user()->currentAccessToken();
            $token->delete();
    
            return $this->ReturnSuccessMessage("Logged out");
          } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
          }

   
    }
}
