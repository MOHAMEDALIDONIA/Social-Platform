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
                      <button class="nav-link active" id="nav-post-tab" data-bs-toggle="tab" data-bs-target="#nav-post" type="button" role="tab" aria-controls="nav-post" aria-selected="true">My Posts</button>
                      <button class="nav-link" id="nav-friend-tab" data-bs-toggle="tab" data-bs-target="#nav-friend" type="button" role="tab" aria-controls="nav-friend" aria-selected="false">Friends</button>
                      <button class="nav-link" id="nav-request-tab" data-bs-toggle="tab" data-bs-target="#nav-request" type="button" role="tab" aria-controls="nav-request" aria-selected="false">request</button>
                     
 
                    </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-post" role="tabpanel" aria-labelledby="nav-post-tab" tabindex="0">
                          <!--- \\\\\\\Post-->

                          <div class="container" style="margin-top: 30px;>
                            <div class="form-container">
                                <h3 class="text-center mb-4">Create a Post</h3>
                                
                                <form>
                                    <!-- Post Text -->
                                    <div class="mb-3">
                                        <label for="postText" class="form-label">Post Text</label>
                                        <textarea class="form-control" id="postText" rows="4" placeholder="What's on your mind?"></textarea>
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="mb-3">
                                        <label for="postImages" class="form-label">Upload Images</label>
                                        <input type="file" class="form-control" id="postImages" accept="image/*" multiple>
                                        <div id="imagePreview" class="post-image-preview mt-2"></div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Post</button>
                                    </div>
                                </form>
                            </div>
                          </div>
                          <div class="card gedf-card" style="margin-top: 30px;">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-2">
                                            <img class="rounded-circle" width="45" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                        </div>
                                        <div class="ml-2">
                                            <div class="h5 m-0">{{$user->name}}</div>
                                            <div class="h7 text-muted">{{$user->email}}</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="dropdown">
                                            <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                                <div class="h6 dropdown-header">Configuration</div>
                                                <a class="dropdown-item" href="#">Save</a>
                                                <a class="dropdown-item" href="#">Hide</a>
                                                <a class="dropdown-item" href="#">Report</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>10 min ago</div>
                                <a class="card-link" href="#">
                                    <h5 class="card-title">Lorem ipsum dolor sit amet, consectetur adip.</h5>
                                </a>

                                <p class="card-text">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo recusandae nulla rem eos ipsa praesentium esse magnam nemo dolor
                                    sequi fuga quia quaerat cum, obcaecati hic, molestias minima iste voluptates.
                                </p>
                            </div>
                            <div class="card-footer">
                                <a href="#" class="card-link"><i class="fa fa-gittip"></i> Like</a>
                                <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
                                <a href="#" class="card-link"><i class="fa fa-mail-forward"></i> Share</a>
                            </div>
                        </div>
                        <!-- Post /////-->

                    </div>
              
                    <div class="tab-pane fade" id="nav-friend" role="tabpanel" aria-labelledby="nav-friend-tab" tabindex="0">
                      <div class="container mt-5">
                          <h2 class="text-center mb-4">Friends List</h2>
                          <div class="row g-4">
                             @foreach ($userfriends as $userfriend)
                                  <div class="col-12 col-md-4">
                                    <div class="friend-card">
                                        <a href="{{route('profile.view',$userfriend)}}"><img src="{{asset('storage/'.$userfriend->image)}}" alt="User Image" class="profile-image-user-friend "></a>
                                        <h6 class="friend-name">{{$userfriend->name}}</h6>
                                        <p class="friend-email">{{$userfriend->email}}</p>
                                    </div>
                                </div>
                             @endforeach
                              
                             
                      
                        
                      
                        
                          </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="nav-request" role="tabpanel" aria-labelledby="nav-request-tab" tabindex="0">...</div>

                  </div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
    
<!-- JavaScript to Preview Images -->
<script>
  const postImages = document.getElementById('postImages');
  const imagePreview = document.getElementById('imagePreview');

  postImages.addEventListener('change', function() {
      imagePreview.innerHTML = ''; // Clear previous images
      Array.from(postImages.files).forEach(file => {
          const reader = new FileReader();
          reader.onload = function(e) {
              const img = document.createElement('img');
              img.src = e.target.result;
              imagePreview.appendChild(img);
          }
          reader.readAsDataURL(file);
      });
  });
</script>
@endsection



