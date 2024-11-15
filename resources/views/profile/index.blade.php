<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
</head>
<body>

<div class="container">
	
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>