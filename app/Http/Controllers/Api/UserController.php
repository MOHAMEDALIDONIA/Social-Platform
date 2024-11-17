<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FriendConnection;
use App\Models\FriendRequest;
use App\Models\User;
use App\services\UserServices;
use App\traits\apiTraits;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use apiTraits;
    public function GetSuggestedConnections(Request $request){
      $userId = $request->user()->id;
    
      // fetch users don't send friend requests
      $SuggestedConnections = User::suggestedConnections($userId)->paginate(12);

      return $this->ReturnData('SuggestedConnections',$SuggestedConnections,"Suggested connections fetched successfully");
    }
    public function GetFriendRequests(Request $request){
      $userId = $request->user()->id;
      $FriendRequests = FriendRequest::ShowMyFriendRequest($userId)->paginate(12);
      return $this->ReturnData('FriendRequests',$FriendRequests,"Friend Requests fetched successfully");
      
    }
    public function SendFriendRequest(Request $request,UserServices $service){
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
    
   
      
     
  }
  public function AcceptFriendRequest(Request $request) {
      //validation request 
      $rules = [
        'friend_request_id' => 'required|exists:friend_requests,id',
        
       ];
       $massage= $this->ReturnValidationError($request,$rules);
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
  }
    public function RejectFriendRequest(Request $request) {
        //validation request 
        $rules = [
        'friend_request_id' => 'required|exists:friend_requests,id',
        
        ];
        $massage= $this->ReturnValidationError($request,$rules);
        if(isset($massage)){
          return $massage;
        }
        //check friend request exist or not 
        $friendrequest = FriendRequest::findOrFail($request->friend_request_id);

        //delete record friendrequest 
        $friendrequest->delete();
        
        return $this->ReturnSuccessMessage('Reject Friend Request Successfully');
    }
  
}
