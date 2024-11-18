<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        const userId = {{ auth()->user()->id }};
        //'send-friend-request'
        //`user${userId}`
      // Enable pusher logging - don't include this in production
      Pusher.logToConsole = true;
  
      var pusher = new Pusher('6906a6a7bc9340a75919', {
        cluster: 'ap2'
      });
  

  
   
    var channel = pusher.subscribe(`user${userId}`);
    channel.bind('send-friend-request', function(data) {
      if (data.user.message) {
 
        toastr.success('New message Created', data.user.message, {
                timeOut: 0,  
                extendedTimeOut: 0,  
                });
      } else {
        console.error('Invalid data structure received:', data);
      }
    });
    var channel = pusher.subscribe(`user-like-post${userId}`);
    channel.bind('liked-post', function(data) {
      if (data.LikedPost.message ) {
 
        toastr.success('New message Created', data.LikedPost.message, {
                timeOut: 0,  
                extendedTimeOut: 0,  
                });
      } else {
        console.error('Invalid data structure received:', data);
      }
    });
    var channel = pusher.subscribe(`user-comment-post${userId}`);
    channel.bind('comment-post', function(data) {
      if (data.CommentPost.message ) {
 
        toastr.success('New message Created', data.CommentPost.message, {
                timeOut: 0,  
                extendedTimeOut: 0,  
                });
      } else {
        console.error('Invalid data structure received:', data);
      }
    });
  
    </script>
</head>
<body>
    @include('layouts.frontend.navbar')
    @yield('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

</body>
</html>
