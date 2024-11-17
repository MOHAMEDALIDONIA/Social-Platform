<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\Post;
use App\Models\User;
use App\services\UserServices;
use App\traits\apiTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use apiTraits;
    protected $Service;

    public function __construct(UserServices $Service)
    {
        $this->Service = $Service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user('sanctum');
        $userfriends = User::Friendslist($user->id)->get();
        $userposts = Post::where('user_id',$user->id)->with('comments')->latest()->get();
        $data =['user' => $user,'userfriends'=> $userfriends,'userposts'=>$userposts];
        return  $this->ReturnData('data',$data,"Success");
    }


    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::FindOrFail($id);
           // authorization

        if ($user->id !== Auth::guard('sanctum')->user()->id) {
            return  $this->ReturnErrorMessage("unauthorized","403");
         }

        $data = ['user'=>$user];
        return  $this->ReturnData('data',$data,"Success show user");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
           // check user found
           $user = User::FindOrFail($id);
           // authorization

          if ($user->id !== Auth::guard('sanctum')->user()->id) {
             return  $this->ReturnErrorMessage("unauthorized","403");
          }
         
           //update user data 
           $message =  $this->Service->UpdateUserData($user,$request);;
           if(isset($message)){
             return $message;
           }
          
           
           //return success message
           return $this->ReturnSuccessMessage('Update Data Successfully');
    }
    public function ChangePassword(Request $request){
        
        //validation of request
        $rules =[
            'current_password' => ['required','string'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];
        $message = $this->ReturnValidationError($request,$rules);
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
              return $this->ReturnSuccessMessage('Password Updated Successfully');
            
       

        }

        

              //return success message
              return $this->ReturnErrorMessage('Current Password does not match with Old Password',"800");
      
        
    }

 
}
