@extends('layouts.app')
@section('title','Friend Requests')
@section('content')
<div class="container" style="margin-top: 40px;">
     @forelse ($FriendRequests as $FriendRequest)
        <div class="user-card bg-light">
            <!-- Left side: Image and name -->
            <div class="d-flex align-items-center">
                <img src="{{asset('storage/'.$FriendRequest->userSender->image)}}" alt="User Image" class="profile-image me-3">
                <div>
                    <h6 class="mb-0">{{$FriendRequest->userSender->name}}</h6>
                    <small class="text-muted">{{$FriendRequest->userSender->email}}</small>
                </div>
            </div>

            <!-- Right side: Buttons -->
            <div>
                <button class="btn btn-success btn-sm me-2">Accept</button>
                <button class="btn btn-danger btn-sm">Reject</button>
            </div>
        </div>
     @empty
        <div class="user-card bg-light">
            <!-- Left side: Image and name -->
            <div class="d-flex align-items-center">
                
                <div>
                    <h6 class="mb-0">Not Available Friend Request </h6>

                </div>
            </div>

            <!-- Right side: Buttons -->
        
        </div>
     @endforelse
     
      
</div
@endsection