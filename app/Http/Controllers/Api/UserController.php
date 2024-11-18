<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FriendConnection;
use App\Models\FriendRequest;
use App\Models\User;
use App\services\UserServices;
use App\traits\apiTraits;
use Illuminate\Http\Request;
/**
 * @group User 
 * 
 * APIs for managing friend request, accept and reject friends , show friends.
 */
class UserController extends Controller
{
    use apiTraits;

    /**
     * Retrieve suggested connections for the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Suggested connections fetched successfully",
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
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function GetSuggestedConnections(Request $request){
    
      try {
        $userId = $request->user()->id;
    
        // fetch users don't send friend requests
        $SuggestedConnections = User::suggestedConnections($userId)->paginate(12);
  
        return $this->ReturnData('SuggestedConnections',$SuggestedConnections,"Suggested connections fetched successfully");
      } catch (\Exception $th) {
        return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
      }

    }
        /**
     * Retrieve all friend requests for the authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Friend Requests fetched successfully",
     *   "data": [
     *     {
     *       "id": 1,
     *       "sender_id": 3,
     *       "receiver_id": 2,
     *       "status": "pending",
     *       // Additional friend request fields
     *     }
     *   ]
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function GetFriendRequests(Request $request){
      try {
        $userId = $request->user()->id;
        $FriendRequests = FriendRequest::ShowMyFriendRequest($userId)->paginate(12);
        return $this->ReturnData('FriendRequests',$FriendRequests,"Friend Requests fetched successfully");
      } catch (\Exception $th) {
        return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
      }

      
    }
       /**
     * Send a friend request to another user.
     *
     * @param Request $request
     * @param UserServices $service
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam friend_id int required The ID of the user to send a friend request to. Example: 5
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Friend request sent successfully"
     * }
     *
     * @response 400 {
     *   "status": false,
     *   "message": "Friend request already exists"
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
    public function SendFriendRequest(Request $request,UserServices $service){
      try {
              //validation request 
        $rules = [
          'friend_id' => 'required|exists:users,id',
          
        ];
        $massage= $this->ReturnValidationError($request,$rules);
        if(isset($massage)){
          return $massage;
        }
      
      
        // add friend request to database
        $senderId = $request->user()->id;
        $receiverId = $request->friend_id;

        return $service->CheckFriendRequestExist($senderId,$receiverId);
      } catch (\Exception $th) {
        return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
      }
   
    
   
      
     
  }
   /**
     * Accept a pending friend request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam friend_request_id int required The ID of the friend request to accept. Example: 1
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Friend request accepted successfully"
     * }
     *
     * @response 400 {
     *   "status": false,
     *   "message": "Friend request not found"
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
  public function AcceptFriendRequest(Request $request) {
    try {
          //validation request 
  
       $massage= $this->ReturnValidationError($request,    ['friend_request_id' => 'required|exists:friend_requests,id',]);
       if(isset($massage)){
         return $massage;
       }
    
       //check friend request exist or not 
        $friendrequest = FriendRequest::findOrFail($request->friend_request_id);

        //add to friend connections table
        FriendConnection::create([
          'user_id' => $friendrequest->receiver_id,
          'friend_id'=>$friendrequest->sender_id
        ]);
        //delete record friendrequest 
        $friendrequest->delete();

        return $this->ReturnSuccessMessage('Accept Friend Request Successfully');
    } catch (\Exception $th) {
      return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
    }
   
  }
      /**
     * Reject a pending friend request.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam friend_request_id int required The ID of the friend request to reject. Example: 1
     *
     * @response 200 {
     *   "status": true,
     *   "message": "Friend request rejected successfully"
     * }
     *
     * @response 400 {
     *   "status": false,
     *   "message": "Friend request not found"
     * }
     *
     * @response 500 {
     *   "status": false,
     *   "message": "An error occurred Internal Server Error"
     * }
     */
  public function RejectFriendRequest(Request $request) {
      try {
         //validation request 
      
         $massage= $this->ReturnValidationError($request, ['friend_request_id' => 'required|exists:friend_requests,id',]);
         if(isset($massage)){
           return $massage;
         }
         //check friend request exist or not 
         $friendrequest = FriendRequest::findOrFail($request->friend_request_id);
 
         //delete record friendrequest 
         $friendrequest->delete();
         
         return $this->ReturnSuccessMessage('Reject Friend Request Successfully');
      } catch (\Exception $th) {
        return $this->ReturnErrorMessage("An error occurred Internal Server Error","500");
      }
       
  }
  
}
