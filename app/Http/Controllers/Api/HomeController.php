<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\traits\apiTraits;
use Illuminate\Http\Request;
/**
 * @group Home Page
 * 
 * APIs for managing posts home page, search.
 */
class HomeController extends Controller
{
    use apiTraits;
      /**
     * Display a paginated list of posts for the home page.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Show Home Page",
     *   "data": [
     *     {
     *       "id": 1,
     *       "user": {
     *         "id": 1,
     *         "name": "User Name",
     *         // Additional user fields
     *       },
     *       "comments": [
     *         {
     *           "id": 1,
     *           "content": "Comment Content",
     *           // Additional comment fields
     *         }
     *       ],
     *       "likes": [
     *         {
     *           "id": 1,
     *           "user_id": 1,
     *           // Additional like fields
     *         }
     *       ],
     *       "images": [
     *         {
     *           "id": 1,
     *           "url": "image_url.jpg",
     *           // Additional image fields
     *         }
     *       ]
     *       // Additional post fields
     *     }
     *   ]
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function view(){
        try {
            $posts = Post::with(['user','comments','likes','images'])->latest()->paginate(10);
            return $this->ReturnData('data',$posts,'Show Home Page');
          } catch (\Exception $th) {
            return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
          }
      
       
    }
       /**
     * Search for users based on a query, excluding the authenticated user.
     *
     * @param Request $request
     * @queryParam search required The search term for matching users by name or email. Example: "john"
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Process successfully",
     *   "data": [
     *     {
     *       "id": 2,
     *       "name": "John Doe",
     *       "email": "john@example.com",
     *       // Additional user fields
     *     }
     *   ]
     * }
     *
     * @response 404 {
     *   "status": false,
     *   "message": "search not found"
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function search(Request $request){
     try {  
        if ($request->search) {
            $searchUsers = User::whereNot('id',auth()->user()->id)
                                ->where('name','LIKE','%'.$request->search.'%')
                                ->orWhere('email','LIKE','%'.$request->search.'%')
                                ->latest()->paginate(20);
                                return $this->ReturnData('data',$searchUsers,'Proccess successfully');
        } else {
            return $this->ReturnErrorMessage(" search not found","404");
        }
     } catch (\Exception $th) {
        return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
      } 

    }
}
