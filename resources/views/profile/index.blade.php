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
                      <!-- Post Form -->
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
                                  </div>
                                  <!-- Submit Button -->
                                  <div class="d-grid">
                                      <button type="submit" class="btn btn-primary">Post</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  
                      <!-- Display Posts -->
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
                  
                          <!-- Post Content -->
                          <div class="card-body">
                              <div class="text-muted h7 mb-2"><i class="fa fa-clock-o"></i> {{$post->created_at}}</div>
                              <p class="card-text">{{ $post->content }}</p>
                          </div>
                  
                          <!-- Carousel for Images -->
                          <div id="postImagesCarousel{{ $post->id }}" class="carousel slide" data-bs-ride="carousel">
                              <div class="carousel-inner">
                                  @foreach($post->images as $index => $image)
                                  <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                      <img src="{{ asset('storage/' . $image->image) }}" class="d-block w-100" style="width:400px;height:700px;" alt="Post Image">
                                  </div>
                                  @endforeach
                              </div>
                              <button class="carousel-control-prev" type="button" data-bs-target="#postImagesCarousel{{ $post->id }}" data-bs-slide="prev">
                                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                  <span class="visually-hidden">Previous</span>
                              </button>
                              <button class="carousel-control-next" type="button" data-bs-target="#postImagesCarousel{{ $post->id }}" data-bs-slide="next">
                                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                  <span class="visually-hidden">Next</span>
                              </button>
                          </div>
                          <div class="card-footer d-flex justify-content-between align-items-center">
                            <a href="#" class="btn btn-link text-decoration-none"><i class="fa fa-gittip"></i> Likes (7)</a>
                            <a href="#" class="btn btn-link text-decoration-none" ><i class="fa fa-comment"></i> Comments({{$post->comments->count() ?? 0}})</a>
                         </div>
                  
                          <!-- Comments Section -->
                          <div class="card-footer">
                             
                              <h6>Comments</h6>
                            
                              <div id="commentsSection{{ $post->id }}" class="comments-container" style="max-height: 100px; overflow-y: auto;">
                                  <!-- Display up to 2-3 comments initially -->
                                  @foreach($post->comments as $comment)
                                  <div class="comment">
                                      <strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}
                                  </div>
                                  @endforeach
                              </div>
                  
                          
                  
                              <!-- Add Comment Form -->
                              <form method="POST" action="{{route('post.comment', $post->id)}}" class="formcomment mt-2" data-post-id="{{ $post->id }}" >
                                  @csrf
                                  <div class="input-group">
                                      <input type="text" name="content" id="content{{$post->id}}" class="form-control" placeholder="Write a comment..." required>
                                      <button class="btn btn-primary" type="submit">Comment</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                      @empty
                      <p>No posts available.</p>
                      @endforelse
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
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $(document).ready(function() {
        // Set up CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      
        $('.formcomment').on('submit', function(e) {
           
          e.preventDefault(); 
          
            let  postId = $(this).data('post-id');
            let  content = $('#content' + postId).val();
            

     
            $.ajax({
                url: `/Posts/post-comment/${postId}`, // Template literal with the route structure
                method: 'POST',
                data: { 
                      content: content  
                },
                success: function(response) {
                   if (response.message = 'success') {
                      $('#commentsSection' + postId).append(`
                          <div class="comment"><strong>${response.user}</strong>: ${content}</div>
                      `);
                      $('#content' + postId).val('');

                      // Increment the comment count
                      let commentCount = parseInt($('#commentCount' + postId).text());
                      $('#commentCount' + postId).text(commentCount + 1);
                   }
 
                },
                error: function(xhr) {
                    console.error("An error occurred:", xhr.responseText);
                    alert("There was an error adding your comment. Please try again.");
                }
            });
               
        });
    });
</script> 
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
<!-- Script to Show More Comments -->

@endsection



