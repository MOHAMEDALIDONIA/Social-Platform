<?php
namespace App\services;

use App\Models\FriendRequest;
use App\traits\apiTraits;
use App\traits\savephoto;
use Illuminate\Support\Facades\File;

class UserServices{
    use savephoto,apiTraits;
    public function UpdateUserData($user,$request){
                //validation of request
                $rules= [    'name' => ['required', 'string', 'max:255'],
                          'email' => ['required', 'string', 'email', 'max:255'],
                          'image'=>['nullable','mimes:jpg,jpeg,png'],
                          'bio'=>['nullable','string']
                        ];
                $message = $this->ReturnValidationError($request,$rules);
                if(isset($message)){
                  return $message;
                }

              //check image exist
             $image = $this->CheckImageExist($request,$user->image,'users\uploads\avaters');
                //insert image to request
                $request->image =$image ?? $user->image;
                
              //update user data
              $user->update([
                 'name'=>$request->name,
                 'email' =>$request->email,
                 'image' => $request->image 
                 
              ]);
              //add or update user bio
              $user->userProfile()->updateOrCreate(
                ['user_id' => $user->id],
                ['bio' => $request->bio]
            );
       
    }
    public function CheckFriendRequestExist($senderId,$receiverId){
        if (FriendRequest::where('sender_id',$senderId)->where('receiver_id',$receiverId)->exists()) {
           return $this->ReturnErrorMessage("Friend request already exists.","410");
           
         } else {
            FriendRequest::create([
              'sender_id' => $senderId,
              'receiver_id'=>$receiverId,
              'status'=>'panding'
            ]);
            return $this->ReturnSuccessMessage("Friend request Send Successfully");
         }
    }

       
    
}