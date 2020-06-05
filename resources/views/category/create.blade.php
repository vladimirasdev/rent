@extends('base')

@section('content')
    <div class="row justify-content-start">
        <h2 class="lead text-muted"><i class="fas fa-layer-group"></i> Create category</h2>
    </div>

    @if($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger mx-auto" style="max-width: 540px;">{{ $error }}</div>
        @endforeach
    @endif

    <div class="justify-content-center row">
        {!! Form::open(array('url' => 'category')) !!}
        {{ csrf_field() }}
            <div class="form-group">
                {!! Form::label('title', 'Title:') !!}
                {!! Form::text('title', old('title'), array('id' => 'title', 'class' => 'form-control', 'autofocus')) !!}

                {!! Form::label('description', 'Description:') !!}
                {!! Form::text('description', old('description'), array('id' => 'description', 'class' => 'form-control')) !!}
            </div>
            {!! Form::submit('Save', array('class' => 'btn btn-block btn-sm btn-primary hov-slide float-right')) !!}
        {!! Form::close() !!}
    </div>
@stop