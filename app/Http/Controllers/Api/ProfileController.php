<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\Post;
use App\Models\User;
use App\services\UserServices;
use App\traits\apiTraits;
use Knuckles\Scribe\Attributes\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
/**
 * @group User Profile
 * 
 * APIs for managing user profile, friends, posts, and password changes.
 */
class ProfileController extends Controller
{
    use apiTraits;
    protected $Service;

    public function __construct(UserServices $Service)
    {
        $this->Service = $Service;
    }
   
    /**
     * Get profile information.
     *
     * Retrieves the authenticated user's profile information, including their friends list and posts.
     *
     * @authenticated
     * 
     * @response 200 {
     *    "status": true,
     *    "message": "Success",
     *    "data": {
     *       "user": {
     *           "id": 1,
     *           "name": "John Doe",
     *           "email": "john@example.com",
     *           "created_at": "2024-11-17T10:20:30.000Z"
     *       },
     *       "userfriends": [
     *          { "id": 2, "name": "Jane Doe" }
     *       ],
     *       "userposts": [
     *          {
     *              "id": 1,
     *              "user_id": 1,
     *              "content": "This is a sample post",
     *              "created_at": "2024-11-17T10:20:30.000Z",
     *              "comments": []
     *          }
     *       ]
     *    }
     * }
     * @return response 500 {
     *    "status": false,
     *    "message": "An error occurred Internal Server Error"
     * }
     */
  
    
   
    public function index(Request $request)
    {
       
          try {
            $user = $request->user('sanctum');
            $userfriends = User::Friendslist($user->id)->get();
            $userposts = Post::where('user_id',$user->id)->with('comments')->latest()->get();
            $data =['user' => $user,'userfriends'=> $userfriends,'userposts'=>$userposts];
            return  $this->ReturnData('data',$data,"Success");
          } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
          }
      
    }


     /**
     * Show specific user profile.
     *
     * Retrieves the profile information of a user by ID.
     *
     * @urlParam id int required The ID of the user. Example: 1
     * @authenticated
     * 
     * @response 200 {
     *    "status": true,
     *    "message": "Success show user",
     *    "data": {
     *        "user": {
     *            "id": 1,
     *            "name": "John Doe",
     *            "email": "john@example.com"
     *        }
     *    }
     * }
     * @response 403 {
     *    "status": false,
     *    "message": "unauthorized"
     * }
     * @response 500 {
     *    "status": false,
     *    "message": "An error occurred Internal Server Error"
     * }
     */
    public function edit(string $id)
    {
        try {
                    $user = User::FindOrFail($id);
                    // authorization
        
                if ($user->id !== Auth::guard('sanctum')->user()->id) {
                    return  $this->ReturnErrorMessage("unauthorized","403");
                }
        
                $data = ['user'=>$user];
                return  $this->ReturnData('data',$data,"Success show user");
          } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
          }
    
    }

    /**
     * Update user profile.
     *
     * Updates the profile information of the authenticated user.
     *
     * @urlParam id int required The ID of the user. Example: 1
     * @authenticated
     * 
     * @bodyParam name string optional The user's name. Example: "John Doe"
     * @bodyParam email string optional The user's email address. Example: "john@example.com"
     * 
     * @response 200 {
     *    "status": true,
     *    "message": "Update Data Successfully"
     * }
     * @response 403 {
     *    "status": false,
     *    "message": "unauthorized"
     * }
     * @response 500 {
     *    "status": false,
     *    "message": "An error occurred Internal Server Error"
     * }
     */
    public function update(Request $request, string $id)
    {
        try {
               // check user found
                $user = User::FindOrFail($id);
                // authorization

                if ($user->id !== Auth::guard('sanctum')->user()->id) {
                    return  $this->ReturnErrorMessage("unauthorized","403");
                }
                
                //update user data 
                $message =  $this->Service->UpdateUserData($user,$request);
                if(isset($message)){
                    return $message;
                }
                
                
                //return success message
                return $this->ReturnSuccessMessage('Update Data Successfully','200');
          } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
          }
   
    }
     /**
     * Change user password.
     *
     * Changes the authenticated user's password.
     *
     * @authenticated
     * 
     * @bodyParam current_password string required The user's current password. Example: "oldpassword"
     * @bodyParam password string required The new password. Example: "newpassword123"
     * @bodyParam password_confirmation string required The confirmation of the new password. Example: "newpassword123"
     * 
     * @response 200 {
     *    "status": true,
     *    "message": "Password Updated Successfully"
     * }
     * @response 800 {
     *    "status": false,
     *    "message": "Current Password does not match with Old Password"
     * }
     * @response 500 {
     *    "status": false,
     *    "message": "An error occurred Internal Server Error"
     * }
     */
    public function ChangePassword(Request $request){
        
        try {
              //validation of request
  
            $message = $this->ReturnValidationError($request,['current_password' => ['required','string'],'password' => ['required', 'string', 'min:8', 'confirmed']]);
            if(isset($message)){
            return $message;
            }
           //check current password correct or not
            $currentPasswordStatus = Hash::check($request->current_password, Auth::guard('sanctum')->user()->password);
            if($currentPasswordStatus){

                User::findOrFail($request->user()->id)->update([
                    'password' => Hash::make($request->password),
                ]);

            //return success message
                return $this->ReturnSuccessMessage('Password Updated Successfully',"200");
                
        

            }

        

              //return success message
            return $this->ReturnErrorMessage('Current Password does not match with Old Password',"800");
          } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
          }
       
      
        
    }

 
}
