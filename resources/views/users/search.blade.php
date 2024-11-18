@extends('layouts.app')
@section('title','Suggest Connections')
@section('content')
<div class="container mt-5">
 <div class="row g-4">
    @foreach ($searchUsers as $searchUser)
        <!-- User Card -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="user-card-suggest bg-light p-3">
                <a href="{{ route('profile.view', $searchUser->id) }}">
                    <img src="{{ asset('storage/' . $searchUser->image) }}" alt="User Image" class="profile-image-suggest mb-3">
                </a>
                <h6 class="mb-1">{{ $searchUser->name }}</h6>
                <p class="text-muted mb-3">{{ $searchUser->email }}</p>

            </div>
        </div>
    @endforeach  
    <div class="pagination justify-content-center">
        {{$searchUsers->links() }}
    </div> 
 </div>    
</div>
@endsection


