@extends('layouts.app')

@section('content')

<h1>Active Users:</h1>
<div>
    @foreach($users as $user)
        <a href="{{route('chat.create-room',['userOne' => auth()->user()->id,'userTwo' => $user->id])}}">{{$user->name}}</a>
    @endforeach
</div>
@endsection
