@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center">
            <div class="panel panel-default">
                <div class="panel-body">
                    <i class="fa fa-check-circle-o fa-5x text-success" aria-hidden="true"></i>
                    <h2>{{$messages['success']}}</h2>
                    <p>{{$messages['sujest']}}</p><br>
                    <a href="/login" class="btn btn-primary btn-lg">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
