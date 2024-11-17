<?php

namespace App\Http\Controllers\Mvc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use App\traits\savephoto;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    use savephoto;
    public function store(Request $request){
    
          //validation request 
          $validation = $request->validate([
            'content' => ['required', 'string'],
            'image'=>['nullable' ]
          ]);
          //store data to post
          $post =Post::create([
                'user_id'=>auth()->user()->id,
                'content'=>$validation['content']
          ]);
          //store image if it exists 
          if($request->hasFile('image')){
            foreach($request->file('image') as $imageFile){
                //save image to folder 
               $image = $this->SaveImage($imageFile,'users/uploads/post');

                PostImage::create([
                    'post_id' => $post->id,
                    'image' => $image
                ]);
            }
          }
          session('message','Post Added Successfully');
          return redirect()->back();
    }
    public function edit(Request $request,int $post_id){
        $post = Post::findOrFail($post_id);
        $this->authorize('crudPost', $post->user);
        return view('post.edit',compact('post'));
    }
    public function update(Request $request,int $post_id){
         $post = Post::findOrFail($post_id);
         $this->authorize('crudPost', $post->user);
         //validation  request
         $validation = $request->validate([
            'content' => ['required', 'string'],
            'image'=>['nullable' ]
          ]);
          //update content post
          $post->update([
            'content' => $validation['content']
          ]);
          // upload images if they exist
          if($request->hasFile('image')){
            foreach($request->file('image') as $imageFile){
                //save image to folder 
               $image = $this->SaveImage($imageFile,'users/uploads/post');

                PostImage::create([
                    'post_id' => $post->id,
                    'image' => $image
                ]);
            }
          }
          session()->flash('message','Post Updated Successfully');
          return redirect()->back();

    }
    public function destory(int $post_id){
        $post = Post::findOrFail($post_id);
        $this->authorize('crudPost', $post->user);
        if($post->images()){
            foreach($post->images() as $image){
                if(File::exists(public_path('storage/'.$image->image))){
                    File::delete(public_path('storage/'.$image->image));
        
                }

            }
        }
        $post->delete();
        session()->flash('message','Post Deleted Successfully');
        return redirect()->back();
   
    }
    
    public function destoryPostImage($image_id){
        $postImage= PostImage::findOrfail($image_id);
        if(File::exists(public_path('storage/'.$postImage->image))){
            File::delete(public_path('storage/'.$postImage->image));

        }
        $postImage->delete();
        return redirect()->back()->with(['message'=>'Post Image Deleted Successfully']);
    }
    public function CreateComment(Request $request,int $post_id){
           //validation request 
           $validation = $request->validate([
              'content' => ['required','string']
           ]);
           // add comment to database
          $comment = Comment::create([
               'user_id' => auth()->user()->id,
               'post_id'=> $post_id,
               'content'=>$validation['content']
           ]);
           //fecth user name 
             $username = $comment->user->name;
           //success 
           return response()->json(['message'=>'success','user'=>$username]);
    }
    public function likePost(Request $request,int $post_id){
              // add like to database
              $UserLikedPost = Like::where('user_id',auth()->user()->id)->where('post_id',$post_id);
              if ($UserLikedPost->exists()) {
                 $UserLikedPost->delete();
              } else {
                $UserLikedPost->create([
                   'user_id' => auth()->user()->id,
                   'post_id'=>$post_id
                ]);
              }
              $likes = Like::where('post_id',$post_id)->count();
             return response()->json(['message'=>'success','likes_count'=>$likes]);
    }
    public function PostLikes(Request $request,int $post_id){
      $post = Post::findOrFail($post_id);
      $usersLiked =  $post->likes()->select('id','user_id')->with(['user'=>function($q){
         $q->select('id','name','image');
      }])->get()->pluck('user');
       
      return response()->json(['users'=>$usersLiked]);
    }

}
