<?php

namespace App\Http\Controllers\mvc;

use App\Http\Controllers\Controller;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function GetSuggestedConnections(){
        $userId = auth()->user()->id;
        // fetch receiver ids by using user_id
        $receiverIds = FriendRequest::receiverIdsForSender($userId);  
        // fetch users don't send friend requests
        $SuggestedConnections = User::suggestedConnections($userId,$receiverIds)->get();

        return view('users.suggestedconnections' ,compact('SuggestedConnections'));
    }
    public function GetFriendRequests(){
        $FriendRequests = FriendRequest::where('receiver_id',auth()->user()->id)->get();
        return view('users.friendrequests',compact('FriendRequests'));
    }
    public function SendFriendRequest(Request $request){
        // add friend request to database
        $senderId = auth()->user()->id;
        $receiverId = $request->friend_id;

       if (FriendRequest::where('sender_id',$senderId)->where('receiver_id',$receiverId)->exists()) {
          return response()->json(['message' => 'Friend request already exists.']);
       } else {
          FriendRequest::create([
            'sender_id' => $senderId,
            'receiver_id'=>$receiverId,
            'status'=>'panding'
          ]);
         return response()->json(['message' => 'success']);
       }
      
     
        
       
    }
}
