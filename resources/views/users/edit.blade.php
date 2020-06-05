@extends('base')

@section('content')
    <div class="row justify-content-start">
        <h2 class="lead text-muted"><i class="fas fa-pen-square"></i> Edit user</h2>
    </div>

    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger mx-auto" style="max-width: 540px;">{{ $error }}</div>
        @endforeach
    @endif

    @if(session('sendSuccess'))
        <div class="alert alert-success mx-auto" style="max-width: 540px;">{{ session('sendSuccess') ?? '' }}</div>
    @endif

    <div class="justify-content-center row">
        {!! Form::open(array('url' => 'users/' . $user->id, 'method' => 'put')) !!}
            {{ csrf_field() }}
            
            
            <div class="form-group">
                {!! Form::label('username', 'Username:') !!}
                {!! Form::text('username', $user->name, array('id' => 'username', 'class' => 'form-control')) !!}

                {!! Form::label('email', 'Email:') !!}
                {!! Form::text('email', $user->email, array('id' => 'email', 'class' => 'form-control')) !!}
            </div>
            
            <div class="form-group">
                {!! Form::submit('Save', array('class' => 'btn btn-sm btn-primary hov-slide float-right')) !!}
            </div>
        {!! Form::close() !!}
    </div>
@stop