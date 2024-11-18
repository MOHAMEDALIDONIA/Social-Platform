@extends('layouts.app')
@section('title','Suggest Connections')
@section('content')
<div class="container mt-5">
 <div class="row g-4">
    @foreach ($SuggestedConnections as $SuggestedConnection)
        <!-- User Card -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="user-card-suggest bg-light p-3">
                <a href="{{ route('profile.view', $SuggestedConnection->id) }}">
                    <img src="{{ asset('storage/' . $SuggestedConnection->image) }}" alt="User Image" class="profile-image-suggest mb-3">
                </a>
                <h6 class="mb-1">{{ $SuggestedConnection->name }}</h6>
                <p class="text-muted mb-3">{{ $SuggestedConnection->email }}</p>
                <button class="AddFriend btn btn-primary w-100" data-friend-id="{{ $SuggestedConnection->id }}">Add Friend</button>
            </div>
        </div>
    @endforeach  
    <div class="pagination justify-content-center">
        {{$SuggestedConnections->links() }}
    </div> 
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
        $('.AddFriend').on('click', function() {
            let button = $(this);
            let friendId = $(this).data('friend-id');

            $.post('{{ route('send.friend.request') }}', { friend_id: friendId },
                function(response) {
                    if (response.message == 'Friend request Send Successfully') {
                         button.text("panding")
                          .removeClass("btn-primary")
                          .addClass("btn-secondary text-dark")
                          .prop("disabled", true);
                    } 
                       
                    
       
                })
               
        });
    });
</script> 
@endsection
