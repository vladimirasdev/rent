@extends('base')

@section('content')
<div class="container">
    <p><h2 class="text-center text-black-50">Please sign in</h2></p>
    <div class="row justify-content-center">


    {!! Form::open(['url' => 'login']) !!}
        <div class="form-group">
            {!! Form::label('email', 'E-mail address:') !!}
            {!! Form::email('email', old('email'), array('id' => 'email', 'class' => 'form-control')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password', 'Password:') !!}
            {!! Form::password('password', array('id' => 'password', 'class' => 'form-control')) !!}
        </div>
        <button type="submit" class="btn btn-block btn-primary">Sign in</button>
    {!! Form::close() !!}

    </div>
    <div class="row justify-content-center text-center">
        <a class="dropdown-item" href="{{ url('register') }}">New around here? Sign up</a>
        <a class="dropdown-item" href="{{ url('reset') }}">Forgot password?</a>
    </div>
</div>
@stop