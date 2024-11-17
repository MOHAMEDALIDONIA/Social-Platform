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
                $validation = $request->validated();

                //if request exists in image delete from folder and add new photo
                if ($request->hasFile('image')) {
                    if(File::exists(public_path('storage/'.$user->image))){
                        File::delete(public_path('storage/'.$user->image));
                    }
                    $image=$this->SaveImage($request->file('image'),'users\uploads\avaters',600,600); 
                 
                }
                //insert image to request
                $validation['image']=$image ?? $user->image;
                
              //update user data
              $user->update([
                 'name'=>$validation['name'],
                 'email' =>$validation['email'],
                 'image' => $validation['image'] 
                 
              ]);
              //add or update user bio
              $user->userProfile()->updateOrCreate(
                ['user_id' => $user->id],
                ['bio' => $validation['bio']]
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