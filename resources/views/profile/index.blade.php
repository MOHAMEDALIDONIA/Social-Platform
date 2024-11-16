@extends('layouts.app')
@section('title','User Profile')
@section('content')
@if (session('message'))
<div class="alert alert-success alert-dismissible fade show" style="margin-top: 20px;" role="alert">
    <i class="bi bi-check-circle me-1"></i>
     {{session('message')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
 
@endif 
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

                          <div class="container" style="margin-top: 30px;">
                            <div class="form-container">
                                <h3 class="text-center mb-4">Create a Post</h3>
                                
                                <form method="POST" action="{{route('store.post')}}" enctype="multipart/form-data">
                                  @csrf
                                    <!-- Post Text -->
                                    <div class="mb-3">
                                        <label for="postText" class="form-label">Post Text</label>
                                        <textarea class="form-control" name="content" id="postText" rows="4" placeholder="What's on your mind?"></textarea>
                                        @error('content')
                                        <small class="form-text text-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="mb-3">
                                        <label for="postImages" class="form-label">Upload Images</label>
                                        <input type="file" class="form-control" name="image[]" id="postImages" accept="image/*" multiple>
                                        <div id="imagePreview" class="post-image-preview mt-2"></div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Post</button>
                                    </div>
                                </form>
                            </div>
                          </div>
                          @forelse ($userposts as $post)
                              <div class="card gedf-card" style="margin-top: 30px;">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="mr-2">
                                                <img class="rounded-circle" width="45" src="{{asset('storage/'.$user->image)}}" alt="">
                                            </div>
                                            <div style="margin-left: 5px;">
                                                <div class="h5 m-0">{{ $user->name }}</div>
                                                <div class="h7 text-muted">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="dropdown">
                                                <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                                    <div class="h6 dropdown-header">Configuration</div>
                                                    <a class="dropdown-item" href="{{route('post.edit',$post->id)}}">Edit</a>
                                                    <a class="dropdown-item" href="{{route('delete.post',$post->id)}}">Delete</a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="card-body">
                                    <div class="text-muted h7 mb-2"><i class="fa fa-clock-o"></i> {{$post->created_at}}</div>
                                    
                               
                                    <p class="card-text">
                                       {{$post->content}}
                                    </p>
                                </div>
                              
                                <!-- Carousel for Images -->
                                <div id="postImagesCarousel{{ $post->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <!-- Loop through images -->
                                        @foreach($post->images as $index => $image)
                                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->image) }}" class="d-block w-100" style="width:400px;height:700px;"  alt="Post Image">
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Carousel controls -->
                                    <button class="carousel-control-prev" type="button" data-bs-target="#postImagesCarousel{{ $post->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#postImagesCarousel{{ $post->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            
                                <div class="card-footer">
                                    <a href="#" class="card-link"><i class="fa fa-gittip"></i> Like</a>
                                    <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
                                   
                                </div>
                            </div>
                          @empty
                              
                          @endforelse
                       
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



