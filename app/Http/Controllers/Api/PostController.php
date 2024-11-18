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
/**
 * @group Post User
 * 
 * APIs for managing Comments,likes, posts.
 */
class PostController extends Controller
{
    use apiTraits, savephoto;
    protected $Service;

    public function __construct(PostServices $Service)
    {
        $this->Service = $Service;
    }

    /**
     * Store a newly created post in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam content string required The content of the post. Example: "This is a new post."
     * @bodyParam image file optional The image attached to the post.
     *
     * @response 201 {
     *   "status": true,
     *   "message": "Added Post Successfully",
     *   "data": {
     *     "id": 1,
     *     "content": "This is a new post.",
     *     "user_id": 1,
     *     "created_at": "2024-11-18T12:00:00Z",
     *     // Other post fields
     *   }
     * }
     *
     * @response 400 {
     *   "status": false,
     *   "message": "Validation error."
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function store(Request $request)
    {
        try {
            // Validation request
            $message = $this->ReturnValidationError($request, ['content' => ['required', 'string'], 'image' => ['nullable']]);
            if (isset($message)) {
                return $message;
            }

            $post = $this->Service->StorePost($request);

            return $this->ReturnData('post', $post, "Added Post Successfully", "201");
        } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error", "500");
        }
    }

    /**
     * Show the details of the post to be edited.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Success show user",
     *   "data": {
     *     "post": {
     *       "id": 1,
     *       "content": "This is a post",
     *       "user_id": 1,
     *       "created_at": "2024-11-18T12:00:00Z",
     *       // Additional post fields
     *     }
     *   }
     * }
     *
     * @response 403 {
     *   "status": false,
     *   "message": "Unauthorized"
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function edit(string $id)
    {
        try {
            $post = Post::FindOrFail($id);
            
            // Authorization check
            if ($post->user->id !== Auth::guard('sanctum')->user()->id) {
                return $this->ReturnErrorMessage("Unauthorized", "403");
            }

            $data = ['post' => $post];
            return $this->ReturnData('data', $data, "Success show user");
        } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error", "500");
        }
    }

    /**
     * Update the specified post in storage.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam content string required The updated content of the post. Example: "Updated post content."
     * @bodyParam image file optional The updated image attached to the post.
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Updated Post Successfully"
     * }
     *
     * @response 403 {
     *   "status": false,
     *   "message": "Unauthorized"
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function update(Request $request, string $id)
    {
        try {
            $post = Post::findOrFail($id);
            
            // Authorization check
            if ($post->user->id !== Auth::guard('sanctum')->user()->id) {
                return $this->ReturnErrorMessage("Unauthorized", "403");
            }

            // Validation request
            $message = $this->ReturnValidationError($request, ['content' => ['required', 'string'], 'image' => ['nullable']]);
            if (isset($message)) {
                return $message;
            }

            // Update content of post
            $post->update(['content' => $request->content]);

            // Upload image if exists
            if ($request->hasFile('image')) {
                $this->Service->UploadPostImages($request->file('image'), $post);
            }

            return $this->ReturnSuccessMessage("Updated Post Successfully");
        } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error", "500");
        }
    }

    /**
     * Remove the specified post from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Deleted Post Successfully"
     * }
     *
     * @response 403 {
     *   "status": false,
     *   "message": "Unauthorized"
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function destroy(string $id)
    {
        try {
            $post = Post::with('images')->findOrFail($id);;
            
            // Authorization check
            if ($post->user->id !== Auth::guard('sanctum')->user()->id) {
                return $this->ReturnErrorMessage("Unauthorized", "403");
            }

            // Delete post images if they exist
            if ($post->images != null) {
                foreach ($post->images as $image) {
                    $this->DeleteImageFile($image->image);
                }
               
            }

            // Delete the post
            $post->delete();
            return $this->ReturnSuccessMessage("Deleted Post Successfully");
        } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error", "500");
        }
    }

    /**
     * Delete a post image.
     *
     * @param int $image_id
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Post Image Deleted Successfully"
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function destoryPostImage(int $image_id)
    {
        try {
            $postImage = PostImage::findOrFail($image_id);

            // Delete image file
            if ($this->DeleteImageFile($postImage->image)) {
                $postImage->delete();
            }

            return $this->ReturnSuccessMessage('Post Image Deleted Successfully');
        } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error", "500");
        }
    }

    /**
     * Create a comment for a post.
     *
     * @param Request $request
     * @param int $post_id
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam content string required The content of the comment. Example: "Great post!"
     * @bodyParam image file optional The image attached to the comment.
     *
     * @response 200 {
     *   "status": true,
     *   "message": "success comment",
     *   "data": "John Doe"
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function CreateComment(Request $request, int $post_id)
    {
        try {
            // Validation request
            $message = $this->ReturnValidationError($request, ['content' => ['required', 'string'], 'image' => ['nullable']]);
            if (isset($message)) {
                return $message;
            }

            // Add comment to database
            $comment = Comment::create([
                'user_id' => auth('sanctum')->user()->id,
                'post_id' => $post_id,
                'content' => $request->content
            ]);

            // Fetch user name
            $user_name = $comment->user->name;

            return $this->ReturnData('data', $user_name, "success comment");
        } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error", "500");
        }
    }

    /**
     * Like or unlike a post.
     *
     * @param Request $request
     * @param int $post_id
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Liked Post",
     *   "data": {
     *     "likes_count": 5
     *   }
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function likePost(Request $request, int $post_id)
    {
        try {
            $UserLikedPost = Like::where('user_id', $request->user()->id)->where('post_id', $post_id);

            if ($UserLikedPost->exists()) {
                $UserLikedPost->delete();
            } else {
                $UserLikedPost->create([
                    'user_id' => auth()->user()->id,
                    'post_id' => $post_id
                ]);
            }

            // Get updated likes count
            $likes = Like::where('post_id', $post_id)->count();
            return $this->ReturnData('likes_count', $likes, "Liked Post");
        } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error", "500");
        }
    }

    /**
     * Get the users who liked a post.
     *
     * @param Request $request
     * @param int $post_id
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *   "status": true,
     *   "message": "user like post",
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "John Doe",
     *       "image": "/images/johndoe.jpg"
     *     },
     *     // Other users
     *   ]
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function PostLikes(Request $request, int $post_id)
    {
        try {
            $post = Post::findOrFail($post_id);

            $usersLiked = $post->likes()->select('id', 'user_id')->with(['user' => function ($q) {
                $q->select('id', 'name', 'image');
            }])->get()->pluck('user');

            return $this->ReturnData('users', $usersLiked, "user like post");
        } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error", "500");
        }
    }
}
