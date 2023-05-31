<!DOCTYPE html>
<html>
<head>
    <title>Pusher Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<h1>Active Users:</h1>
<div>
    @foreach($users as $user)
        <a href="{{route('chat.create-room',['userOne' => auth()->user()->id,'userTwo' => $user->id])}}">{{$user->name}}</a>
    @endforeach
</div>
</body>
</html>
