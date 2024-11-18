<?php
namespace App\services;

use App\Models\Post;
use App\Models\PostImage;
use App\traits\savephoto;

class PostServices{
    use savephoto;
    public function StorePost($request){
           //store data to post
           $post =Post::create([
            'user_id'=>auth('sanctum')->user()->id,
            'content'=>$request->content
           ]);
         //store image if it exists 
          if($request->hasFile('image')){
              $this->UploadPostImages($request->file('image'),$post);
          }
          return $post;
    }
    public function UploadPostImages($images , $post){
        foreach($images as $imageFile){
            //save image to folder 
           $image = $this->SaveImage($imageFile,'users/uploads/post');

            $post->images()->create([
                'post_id' => $post->id,
                'image' => $image
            ]);
        }
    }
}