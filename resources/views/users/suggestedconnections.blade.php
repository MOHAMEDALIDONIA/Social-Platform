@extends('layouts.app')
@section('title','Suggest Connections')
@section('content')
<div class="container mt-5">
 <div class="row g-4">
    @foreach ($SuggestedConnections as $SuggestedConnection)

            <!-- User Card -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="user-card-suggest bg-light p-3">
                   <a href="{{route('profile.view',$SuggestedConnection->id)}}"> <img src="{{asset('storage/'.$SuggestedConnection->image)}}" alt="User Image" class="profile-image-suggest mb-3"></a>
                    <h6 class="mb-1">{{$SuggestedConnection->name}}</h6>
                    <p class="text-muted mb-3">{{$SuggestedConnection->email}}</p>
                    <button class="btn btn-primary w-100">Add Friend</button>
                </div>
            </div>


        
    @endforeach  
 </div>    
</div>
@endsection