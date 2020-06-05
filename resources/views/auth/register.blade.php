@extends('base')

@section('content')
<div class="container mt-3">
    @if ($errors->any())
        <div class="alert alert-danger mx-auto" style="max-width: 540px;">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
        </div>
    @endif
    <p><h2 class="text-center text-black-50">Register</h2></p>
    <div class="row justify-content-center">
        {!! Form::open(['url' => 'register']) !!}
            <div class="form-group">
                {!! Form::label('name', 'Username:') !!}
                {!! Form::text('name', old('name'), array('id' => 'name', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email:') !!}
                {!! Form::email('email', old('email'), array('id' => 'email', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Password:') !!}
                {!! Form::password('password', array('id' => 'password', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password_confirmation', 'Repeat password:') !!}
                {!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control')) !!}
            </div>
            <button type="submit" class="btn btn-block btn-primary">Sign up</button>
        {!! Form::close() !!}
    </div>
</div>
@stop