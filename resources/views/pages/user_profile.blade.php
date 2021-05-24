@extends('layouts.app')

@section('content')
    <profile-component :user="{{ $user }}" :active_user="{{ $user_data }}"></profile-component>
@endsection
