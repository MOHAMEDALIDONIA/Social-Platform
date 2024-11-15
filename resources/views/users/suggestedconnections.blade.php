@extends('layouts.app')
@section('title','Suggest Connections')
@section('content')
<div class="container mt-5">
    <div class="row g-4">
        <!-- User Card -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="user-card-suggest bg-light p-3">
                <img src="https://via.placeholder.com/80" alt="User Image" class="profile-image-suggest mb-3">
                <h6 class="mb-1">John Doe</h6>
                <p class="text-muted mb-3">johndoe@example.com</p>
                <button class="btn btn-primary w-100">Add Friend</button>
            </div>
        </div>

        <!-- Repeat the card to create the grid layout -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="user-card bg-light p-3">
                <img src="https://via.placeholder.com/80" alt="User Image" class="profile-image-suggest mb-3">
                <h6 class="mb-1">Jane Smith</h6>
                <p class="text-muted mb-3">janesmith@example.com</p>
                <button class="btn btn-primary w-100">Add Friend</button>
            </div>
        </div>

        <!-- Duplicate as needed for additional user cards -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="user-card bg-light p-3">
                <img src="https://via.placeholder.com/80" alt="User Image" class="profile-image-suggest mb-3">
                <h6 class="mb-1">Alice Brown</h6>
                <p class="text-muted mb-3">alicebrown@example.com</p>
                <button class="btn btn-primary w-100">Add Friend</button>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="user-card bg-light p-3">
                <img src="https://via.placeholder.com/80" alt="User Image" class="profile-image-suggest mb-3">
                <h6 class="mb-1">Robert White</h6>
                <p class="text-muted mb-3">robertwhite@example.com</p>
                <button class="btn btn-primary w-100">Add Friend</button>
            </div>
        </div>

    </div>
</div>
@endsection