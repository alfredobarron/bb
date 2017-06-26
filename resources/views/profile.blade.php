@extends('layouts.app')

@section('content')
    <profile :user-auth="{{ $user }}"></profile>
@endsection
