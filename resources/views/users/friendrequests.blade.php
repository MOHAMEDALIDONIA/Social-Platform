@extends('layouts.app')
@section('title','Friend Requests')
@section('content')
<div class="container" style="margin-top: 40px;">
      <!-- Success Message Area -->
      <div id="success-message" class="alert alert-success d-none" role="alert">

      </div>
     @forelse ($FriendRequests as $FriendRequest)
        <div class="user-card bg-light" data-card-id="{{ $FriendRequest->id }}">
            <!-- Left side: Image and name -->
            <div class="d-flex align-items-center">
                <img src="{{asset('storage/'.$FriendRequest->sender->image)}}" alt="User Image" class="profile-image me-3">
                <div>
                    <h6 class="mb-0">{{$FriendRequest->sender->name}}</h6>
                    <small class="text-muted">{{$FriendRequest->sender->email}}</small>
                </div>
            </div>

            <!-- Right side: Buttons -->
            <div>
                <button class="AcceptFriendRequest btn btn-success btn-sm me-2" data-friend-request-id="{{ $FriendRequest->id }}">Accept</button>
                <button class="RejectFriendRequest btn btn-danger btn-sm" data-friend-request-id="{{ $FriendRequest->id }}">Reject</button>
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
     <div class="pagination justify-content-center">
        {{$FriendRequests->links() }}
    </div> 
     
      
    </div>
@endsection

@section('scripts')
 <meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $(document).ready(function() {
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle Add Friend button click
        $('.AcceptFriendRequest').on('click', function() {
        
            let friendRequestId = $(this).data('friend-request-id');
            let card = $(`[data-card-id="${friendRequestId}"]`);

            $.post('{{ route('accept.friend.request') }}', { friend_request_id: friendRequestId },
                function(response) {
                    if(response.message != null) {
                        card.remove();
                        $('#success-message').text(response.message).removeClass('d-none'); 
                        setTimeout(function() {
                            $('#success-message').addClass('d-none');
                        }, 3000);
                   }else{
                     alert("An error occurred. Please try again.")
                   }
       
                })
               
        });
        $('.RejectFriendRequest').on('click', function() {
        
            let friendRequestId = $(this).data('friend-request-id');
            let card = $(`[data-card-id="${friendRequestId}"]`);

            $.ajax({
                
              url:'{{ route('reject.friend.request') }}', 
              method: 'DELETE',
              data: { friend_request_id: friendRequestId },
               success: function(response) {
                    if(response.message == 'Reject Friend Request Successfully') {
                            card.remove();
                            $('#success-message').text(response.message).removeClass('d-none'); 
                            setTimeout(function() {
                                $('#success-message').addClass('d-none');
                            }, 3000);
                    }else{
                        alert("An error occurred. Please try again.")
                    }
                
              }  });
            
        });
    });
</script> 

@endsection