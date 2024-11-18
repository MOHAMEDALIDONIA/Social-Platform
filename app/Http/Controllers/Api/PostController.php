<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostImage;
use App\services\PostServices;
use App\traits\apiTraits;
use App\traits\savephoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
     use apiTraits,savephoto;
     protected $Service;

     public function __construct(PostServices $Service)
     {
         $this->Service = $Service;
     }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                   //validation request 
       
                    $massage= $this->ReturnValidationError($request,['content' => ['required', 'string'],'image'=>['nullable']]);
                    if(isset($massage)){
                        return $massage;
                    }
                
                    $post = $this->Service->StorePost($request);

                    return $this->ReturnData('post',$post,"Added Post SUccessfully");
         
       
    }

    public function edit(string $id)
    {
        $post = Post::FindOrFail($id);
           // authorization

        if ($post->user->id !== Auth::guard('sanctum')->user()->id) {
             return  $this->ReturnErrorMessage("unauthorized","403");
         }

        $data = ['post'=>$post];
        return  $this->ReturnData('data',$data,"Success show user");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    
            $post = Post::findOrFail($id);
                // authorization
        
            if ($post->user->id !== Auth::guard('sanctum')->user()->id) {
                return  $this->ReturnErrorMessage("unauthorized","403");
            }
                
                //validation request 
        
                $massage= $this->ReturnValidationError($request,['content' => ['required', 'string'], 'image'=>['nullable' ]]);
                if(isset($massage)){
                    return $massage;
                }
                //update content post
                $post->update([
                'content' => $request->content
                ]);
                // upload images if they exist
                if($request->hasFile('image')){
                    $this->Service->UploadPostImages($request->file('image'),$post);
                }
                return $this->ReturnSuccessMessage("Updated Post SUccessfully");

      
     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
           // authorization

       if ($post->user->id !== Auth::guard('sanctum')->user()->id) {
          return  $this->ReturnErrorMessage("unauthorized","403");
       }
       if($post->images()){
        foreach($post->images() as $image){
            $this->DeleteImageFile($image->image);
        }
        $post->images()->delete();
      }
        $post->delete();
        return $this->ReturnSuccessMessage("Deleted Post SUccessfully");

    }

    public function destoryPostImage(int $image_id){
        $postImage= PostImage::findOrfail($image_id);
        if($this->DeleteImageFile($postImage->image)){
           
            $postImage->delete();
        }
       
       return $this->ReturnSuccessMessage('Post Image Deleted Successfully');
    }
    public function CreateComment(Request $request,int $post_id){
        //validation request
 
          $massage= $this->ReturnValidationError($request,['content' => ['required', 'string'], 'image'=>['nullable' ]]);
          if(isset($massage)){
            return $massage;
          }
           // add comment to database
          $comment = Comment::create([
               'user_id' => auth('sanctum')->user()->id,
               'post_id'=> $post_id,
               'content'=>$request->content
           ]);
           //fecth user name 
             $user_name = $comment->user->name;
           //success 
           return $this->ReturnData('data',$user_name,"success comment");
    }
    public function likePost(Request $request,int $post_id){
              // add like to database
              $UserLikedPost = Like::where('user_id',$request->user()->id)->where('post_id',$post_id);
              if ($UserLikedPost->exists()) {
                 $UserLikedPost->delete();
              } else {
                $UserLikedPost->create([
                   'user_id' => auth()->user()->id,
                   'post_id'=>$post_id
                ]);
              }
              $likes = Like::where('post_id',$post_id)->count();
             return $this->ReturnData('likes_count',$likes,"Liked Post");
    }
    public function PostLikes(Request $request,int $post_id){
      $post = Post::findOrFail($post_id);
      $usersLiked =  $post->likes()->select('id','user_id')->with(['user'=>function($q){
         $q->select('id','name','image');
      }])->get()->pluck('user');
       
      return $this->ReturnData('users',$usersLiked,"user like post");
    }
}
