<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    @if (session('message'))
   
         {{session('message')}}
  @endif
    <form action="{{route('store.test')}}" method="post">
        @csrf 
        <button type="submit">submit</button>
    </form>
</body>
</html>