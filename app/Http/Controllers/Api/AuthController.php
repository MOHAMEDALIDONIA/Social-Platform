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

class AuthController extends Controller
{
    use apiTraits;
    public function register(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image'=>['nullable','mimes:jpg,jpeg,png'],
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

                    ]);
            }else{
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        

                    ]);
        }
            $token = $user->createToken('API Token')->plainTextToken;
            $value = ['user'=>$user,'token'=>$token];
            return $this->ReturnData('data',$value,"user register successfully");
    }
    public function login(Request $request){
        
       $rules = [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ];
        $massage= $this->ReturnValidationError($request,$rules);
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
       
    }
    public function logout(Request $request){

        $token=  $request->user()->currentAccessToken();
        $token->delete();

        return $this->ReturnSuccessMessage("Logged out");
    }
}
