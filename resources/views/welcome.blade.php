@extends('layouts.app')
@section('title','Home Page')
@section('content')
<div class="container gedf-wrapper">
    <div id="notification-container"></div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="h5">@LeeCross</div>
                    <div class="h7 text-muted">Fullname : Miracles Lee Cross</div>
                    <div class="h7">Developer of web applications, JavaScript, PHP, Java, Python, Ruby, Java, Node.js,
                        etc.
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="h6 text-muted">Followers</div>
                        <div class="h5">5.2342</div>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted">Following</div>
                        <div class="h5">6758</div>
                    </li>
                    <li class="list-group-item">Vestibulum at eros</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 gedf-main">

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

            @forelse ($posts as $post)
            <div class="card gedf-card" style="margin-top: 30px;">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <img class="rounded-circle" width="45" src="{{asset('storage/'.$post->user->image)}}" alt="">
                            </div>
                            <div style="margin-left: 5px;">
                                <div class="h5 m-0">{{ $post->user->name }}</div>
                                <div class="h7 text-muted">{{ $post->user->email }}</div>
                            </div>
                        </div>
                        <div>
                            @can('update', $post)
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
                            @endcan
                        </div>
                    </div>
                </div>
        
                <!-- Post Content -->
                <div class="card-body">
                    <div class="text-muted h7 mb-2"><i class="fa fa-clock-o"></i> {{$post->created_at->diffForHumans()}}</div>
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
                 <!-- Likes and Comments Section -->
                <div class="card-footer d-flex justify-content-between align-items-center">
                  <!-- Likes with Heart Button and Modal Trigger -->
                  <div class="d-flex align-items-center">
                    <!-- Likes Link with Modal Trigger -->
                    <a href="javascript:void(0);" class="btn btn-link text-decoration-none me-2" onclick="showLikesModal({{ $post->id }})">
                        <i class="fa fa-gittip"></i> Likes (<span id="likesCount{{ $post->id }}">{{ $post->likes->count() ?? 0 }}</span>)
                    </a>
                    @if ( $post->likes()->where('user_id', auth()->user()->id)->exists())
                        <button id="likeButton{{ $post->id }}" class="btn btn-link p-0" onclick="toggleLike({{ $post->id }})" style="font-size: 1.5em; .fa-heart-o {color: blue;} .active-heart {color: red;}">
                          <i class="fa fa-heart active-heart" id="heartIcon{{ $post->id }}"></i>
                      </button>
                    @else
                        <button id="likeButton{{ $post->id }}" class="btn btn-link p-0" onclick="toggleLike({{ $post->id }})" style="font-size: 1.5em; .fa-heart-o {color: blue;} .active-heart {color: red;}">
                          <i class="fa fa-heart-o "  id="heartIcon{{ $post->id }}"></i>
                      </button>
                    @endif

                </div>
               

                  <!-- Comments Link with Count -->
                  <a href="#" class="btn btn-link text-decoration-none">
                      <i class="fa fa-comment"></i> Comments (<span id="commentCount{{ $post->id }}">{{ $post->comments->count() ?? 0 }}</span>)
                  </a>
                </div>

                <!-- Comments Section -->
                <div class="card-footer">
                  <h6>Comments</h6>

                  <!-- Scrollable Comments Container -->
                  <div id="commentsSection{{ $post->id }}" class="comments-container" style="max-height: 100px; overflow-y: auto;">
                      @foreach($post->comments as $comment)
                      <div class="comment">
                          <strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}
                      </div>
                      @endforeach
                  </div>

                  <!-- Add Comment Form -->
                  <form method="POST" action="{{ route('post.comment', $post->id) }}" class="formcomment mt-2" data-post-id="{{ $post->id }}">
                      @csrf
                      <div class="input-group">
                          <input type="text" name="content" id="content{{ $post->id }}" class="form-control" placeholder="Write a comment..." required>
                          <button class="btn btn-primary" type="submit">Comment</button>
                      </div>
                  </form>
                </div>

                <!-- Modal for Likes -->
                <div class="modal fade" id="likesModal{{ $post->id }}" tabindex="-1" aria-labelledby="likesModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="likesModalLabel">Likes</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body" id="likesList{{ $post->id }}">
                              <!-- List of users who liked the post will be loaded here -->
                          </div>
                      </div>
                  </div>
                </div>

            </div>
            @empty
            <p>No posts available.</p>
            @endforelse
            <div class="pagination justify-content-center">
                {{$posts->links() }}
            </div> 


    



        </div>
        <div class="col-md-3">
            <div class="card gedf-card" style="margin-bottom:10px;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's content.</p>
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>
            <div class="card gedf-card" style="margin-bottom:10px;">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
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

        // Handle Comment Submission
        $('.formcomment').on('submit', function(e) {
            e.preventDefault(); 
            let postId = $(this).data('post-id');
            let content = $('#content' + postId).val();

            $.ajax({
                url: `/Posts/post-comment/${postId}`,
                method: 'POST',
                data: { content: content },
                success: function(response) {
                    if (response.message === 'success') {
                        $('#commentsSection' + postId).append(`
                            <div class="comment"><strong>${response.user}</strong>: ${content}</div>
                        `);
                        $('#content' + postId).val(''); // Clear input field

                        // Increment comment count
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

    // Toggle Like with Heart Button
    function toggleLike(postId) {
        $.ajax({
            url: `/Posts/post-like/${postId}`,
            method: 'POST',
            success: function(response) {
               let heartIcon = $('#heartIcon' + postId);
                let likesCount = $('#likesCount' + postId);

                if (heartIcon.hasClass('fa-heart-o')) {
                    heartIcon.removeClass('fa-heart-o').addClass('fa-heart active-heart');
                } else {
                    heartIcon.removeClass('fa-heart active-heart').addClass('fa-heart-o');
                }

                // Update likes count
                likesCount.text(response.likes_count);
            },
            error: function(xhr) {
                console.error("An error occurred:", xhr.responseText);
                alert("There was an error updating your like. Please try again.");
            }
        });
    }

    // Show Likes Modal
    function showLikesModal(postId) {
        $('#likesModal' + postId).modal('show'); // Show the modal

        // Fetch and display users who liked the post
        $.ajax({
            url: `/Posts/post-users-likes/${postId}`,
            method: 'GET',
            success: function(response) {
                let likesList = $('#likesList' + postId);
                likesList.empty(); // Clear existing list

                // Append each user to the likes list
                response.users.forEach(user => {
                    likesList.append(`  <div class="user-card bg-light">
                                            <div class="d-flex align-items-center">
                                                 <img src="{{asset('storage/${user.image}')}}" alt="User Image" class="profile-image me-3">
                                                    <div>
                                                       <h6 class="mb-0">${user.name}</h6>
                                                    </div>
                                                    
                                            </div>
                                        </div>`);
                });
            },
            error: function(xhr) {
                console.error("An error occurred:", xhr.responseText);
                alert("There was an error loading likes. Please try again.");
            }
        });
    }
</script> 
{{-- <script>
   
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  
     Pusher.logToConsole = true;
     var pusher = new Pusher('6906a6a7bc9340a75919', {
      cluster: 'ap2'
    });
    var channel = pusher.subscribe('my-channel');
    channel.bind('SendFriendRequest', function(data) {
      if (data && data.post && data.post.author && data.post.title) {
        toastr.success('New Post Created', 'Author: ' + data.post.author + '<br>Title: ' + data.post.title, {
          timeOut: 0,  
          extendedTimeOut: 0,  
        });
      } else {
        console.error('Invalid data structure received:', data);
      }
    });



</script> --}}
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