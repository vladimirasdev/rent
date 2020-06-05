@extends('base')

@section('content')
    <div class="row justify-content-start">
        <h2 class="lead text-muted"><i class="fas fa-pen-square"></i> Edit category</h2>
    </div>

    @if($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger mx-auto" style="max-width: 540px;">{{ $error }}</div>
        @endforeach
    @endif

    <div class="justify-content-center row">
        {!! Form::open(array('url' => 'category/' . $category->id, 'method' => 'put')) !!}
            {{ csrf_field() }}
            <div class="form-group">
                {!! Form::label('title', 'Title:') !!}
                {!! Form::text('title', $category->title, array('id' => 'title', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description:') !!}
                {!! Form::text('description', $category->description, array('id' => 'description', 'class' => 'form-control')) !!}
            </div>
            {!! Form::submit('Save', array('class' => 'btn btn-block btn-sm btn-primary hov-slide float-right')) !!}
        {!! Form::close() !!}
    </div>
@stop