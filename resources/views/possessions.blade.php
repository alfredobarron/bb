@extends('layouts.app')

@section('content')
  <possessions :auth-user="{{Auth::user()}}"></possessions>
@endsection
