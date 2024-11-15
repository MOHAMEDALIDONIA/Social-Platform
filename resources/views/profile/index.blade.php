@extends('layouts.app')
@section('title','User Profile')
@section('content')
<div class="container" style="margin-top: 40px;">
	
	<div class="row">
		<div class="col-xs-12 col-md-4 col-lg-3">
			<div class="userProfileInfo">
				<div class="image text-center">
                    @if ($user->image)
                      <img src="{{asset('storage/'.$user->image)}}" alt="#" class="img-responsive"> 
                    @endif

					{{-- <a href="#" title="#" class="editImage">
						<i class="fa fa-camera"></i>
					</a> --}}
				</div>
				<div class="box">
					<div class="name"><strong>{{$user->name}}</strong> 
                        <br>
                        @if ($user->userProfile)
                           <p>{{$user->userProfile->bio}}</p> 
                        @endif
                     
                    </div>
                   
					<div class="info">
						<span><i class="fa fa-fw fa-clock-o"></i>Email : {{$user->email}}</span>
						<span><i class="fa fa-fw fa-list-alt"></i> <a href="#" title="#">name@example.com</a></span>
						<span><i class="fa fa-fw fa-usd"></i> Best street No. 554/7A<br>949 01 Florida<br>United States</span>
                        <a href="{{route('profile.edit',$user->id)}}" class="btn btn-primary  d-grid gap-2 col-6 mx-auto">Edit Profile</a>
					</div>
				
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-md-8 col-lg-9">
			<div class="box">
				<h2 class="boxTitle">Personal information</h2>
                @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                     {{session('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                 
                @endif 
                <nav>
                    <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                      <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
                      <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
                      <button class="nav-link" id="nav-request-tab" data-bs-toggle="tab" data-bs-target="#nav-request" type="button" role="tab" aria-controls="nav-request" aria-selected="false">request</button>
                     
 
                    </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">...</div>
              
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">...</div>
                    <div class="tab-pane fade" id="nav-request" role="tabpanel" aria-labelledby="nav-request-tab" tabindex="0">...</div>

                  </div>
			</div>
		</div>
	</div>
</div>
@endsection



