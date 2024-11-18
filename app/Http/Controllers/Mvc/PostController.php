<?php

namespace App\Http\Controllers\Mvc;

use App\Events\NotificationCommentEvent;
use App\Events\NotificationLikeEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use App\services\PostServices;
use App\traits\apiTraits;
use App\traits\savephoto;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    use savephoto,apiTraits;
    protected $Service;
    public function __construct(PostServices $Service)
    {
        $this->Service = $Service;
    }
    public function store(Request $request){
    
            //validation request 
             $massage= $this->ReturnValidationError($request,['content' => ['required', 'string'],'image'=>['nullable']]);
             if(isset($massage)){
                return $massage;
             }
                
            $this->Service->StorePost($request);
          session('message','Post Added Successfully');
          return redirect()->back();
    }
    public function edit(Request $request,int $post_id){
        $post = Post::findOrFail($post_id);
        $this->authorize('update', $post);
        return view('post.edit',compact('post'));
    }
    public function update(Request $request,int $post_id){
         $post = Post::findOrFail($post_id);
         $this->authorize('update', $post);
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
          session()->flash('message','Post Updated Successfully');
          return redirect()->back();

    }
    public function destory(int $post_id){
        $post = Post::with('images')->findOrFail($post_id);
        $this->authorize('delete', $post);
        if($post->images != null){
            foreach($post->images as $image){
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
        if($this->DeleteImageFile($postImage->image)){
           
          $postImage->delete();
       }
        return redirect()->back()->with(['message'=>'Post Image Deleted Successfully']);
    }
    public function CreateComment(Request $request,int $post_id){
           //validation request 
           $validation = $request->validate([
              'content' => ['required','string']
           ]);
           $post = Post::findOrFail($post_id);
           // add comment to database
           if (auth()->user()->id != $post->user->id) {
                $data =[
                    'message' =>auth()->user()->name . " Comment your Post ( " .$post->content." )"
                ];
              event(new NotificationCommentEvent($data,$post_id));
           }
         
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
                $post = Post::findOrFail($post_id);
                if (auth()->user()->id != $post->user->id) { 
                    $data =[
                        'message' =>auth()->user()->name . " Liked your Post"
                    ];
                    event(new NotificationLikeEvent($data,$post_id));
               } 
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
