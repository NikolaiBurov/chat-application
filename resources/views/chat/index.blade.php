@extends('layouts.app')

@section('content')
    <link href="https://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">

    <div class="container bootstrap snippets bootdey">
        <div class="header">
            <h3 class="text-muted prj-name">
                <span class="fa fa-users fa-2x"></span>
                Users :
            </h3>
        </div>

        <div class="jumbotron" style="min-height:400px;height:auto;">
            <ul class="list-group">
                @foreach($users as $user)
                <li class="list-group-item user-item text-left">
                    <img class="img-circle img-user img-thumbnail " src="https://bootdey.com/img/Content/avatar/avatar7.png">
                    <h3>
                        <a href="{{route('chat.create-room',['userOne' => auth()->user()->id,'userTwo' => $user->id])}}">{{$user->name}}</a><br>
                    </h3>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
