<?php

namespace App\Http\Controllers\Mvc;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeUserPassword;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use App\services\UserProfileServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    
    protected $Service;

    public function __construct(UserProfileServices $Service)
    {
        $this->Service = $Service;
    }
    public function index(int $user_id){
        $user = User::FindOrFail($user_id);
        return view('profile.index',compact('user'));
    }
    public function edit(int $user_id){
        $user = User::FindOrFail($user_id);
        return view('profile.edit',compact('user'));
    }
    public function update(UpdateUserProfileRequest $request , int $user_id){
        // check user found
        $user = User::FindOrFail($user_id);
      
        //update user data 
        $this->Service->UpdateUserData($user,$request);
       
        
        //return success message
        return redirect()->route('profile.view',$user->id)
                  ->with('message','Update Data Successfully');
        

    }
    public function ChangePassword(ChangeUserPassword $request){
        
          //validation of request
          $validation = $request->validated();
         //check current password correct or not
          $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);
          if($currentPasswordStatus){
  
              User::findOrFail(Auth::user()->id)->update([
                  'password' => Hash::make($request->password),
              ]);

             //return success message
                return redirect()->back()
                ->with('message','Password Updated Successfully');
              
         
  
          }else{
  
          

                //return success message
                return redirect()->back()
                ->with('error','Current Password does not match with Old Password');
        
          }
    }
}
