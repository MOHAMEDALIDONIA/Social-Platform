<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pusher Test</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script>
      
          // Enable pusher logging - don't include this in production
          Pusher.logToConsole = true;
      
          var pusher = new Pusher('6906a6a7bc9340a75919', {
            cluster: 'ap2'
          });
      

  
 
            var channel = pusher.subscribe('my-chann');
            channel.bind('form-sub', function(data) {
            if (data && data.message ) {
                toastr.success('New message Created', 'Author: ' + data.message + '<br>Title: ' + data.message, {
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
        <h1>Pusher Test</h1>
        <p>
          Try publishing an event to channel <code>my-channel</code>
          with event name <code>my-event</code>.
        </p>
      </body>
</html>