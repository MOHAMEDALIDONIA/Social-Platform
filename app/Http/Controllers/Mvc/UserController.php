<?php

namespace App\Http\Controllers\mvc;

use App\Events\SendFriendRequest;
use App\Events\SendFriendRequestEvent;
use App\Http\Controllers\Controller;
use App\Models\FriendConnection;
use App\Models\FriendRequest;
use App\Models\User;
use App\services\UserServices;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function GetSuggestedConnections(){
        $userId = auth()->user()->id;
      
        // fetch users don't send friend requests
        $SuggestedConnections = User::suggestedConnections($userId)->paginate(12);

        return view('users.suggestedconnections' ,compact('SuggestedConnections'));
    }
    public function GetFriendRequests(){
        $userId = auth()->user()->id;
        $FriendRequests = FriendRequest::ShowMyFriendRequest($userId)->paginate(10);
        return view('users.friendrequests',compact('FriendRequests'));
    }
    public function SendFriendRequest(Request $request,UserServices $service){
        // add friend request to database
        $senderId = auth()->user()->id;
        $receiverId = $request->friend_id;
   
        $data =[
          'message'=>'('.auth()->user()->name . ') and (' .auth()->user()->email. ") send friend request "
        ];
        event(new SendFriendRequestEvent($data,$receiverId));

     return  $service->CheckFriendRequestExist($senderId,$receiverId); 
      
     
        
       
    }
    public function AcceptFriendRequest(Request $request) {
        //check friend request exist or not 
        $friendrequest = FriendRequest::findOrFail($request->friend_request_id);

        //add to friend connections table
        FriendConnection::create([
           'user_id' => $friendrequest->receiver_id,
           'friend_id'=>$friendrequest->sender_id
        ]);
        //delete record friendrequest 
        $friendrequest->delete();

        return response()->json(['message'=>'Accept Friend Request Successfully']);
    }
    public function RejectFriendRequest(Request $request) {
        //check friend request exist or not 
        $friendrequest = FriendRequest::findOrFail($request->friend_request_id);

        //delete record friendrequest 
        $friendrequest->delete();
        
        return response()->json(['message'=>'Reject Friend Request Successfully']);
    }
  
}
