<?php
namespace App\services;

use App\traits\savephoto;
use Illuminate\Support\Facades\File;

class UserProfileServices{
    use savephoto;
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
       
    
}