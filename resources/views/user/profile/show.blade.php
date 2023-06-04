<!-- profile/show.blade.php -->

@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    <div class="profile-container">
        <h1>{{ $user->name }}</h1>
        <p>Email: {{ $user->email }}</p>

        <div class="profile-picture-container">
            {!! \App\Http\Helpers\BladeHelper::showUserPicture($user) !!}
        </div>

        <!-- Add more profile information here as needed -->

        <a href="{{ route('profile.edit', $user->id) }}" class="edit-btn">Edit Profile</a>
    </div>
@endsection
