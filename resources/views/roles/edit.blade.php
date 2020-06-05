@extends('base')

@section('content')
    <div class="row justify-content-start">
        <h2 class="lead text-muted"><i class="fas fa-pen-square"></i> Edit {{ App\User::find($role->id)->name }} role</h2>
    </div>

    @if($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger mx-auto" style="max-width: 540px;">{{ $error }}</div>
        @endforeach
    @endif

    <div class="justify-content-center row">
        {!! Form::open(array('url' => 'roles/' . $role->id, 'method' => 'put', 'class' => 'w-50 mb-3')) !!}
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $role->id }}" />
            <div class="form-group">
                {!! Form::label('level', 'Level:') !!}
                {!! Form::number('level', $role->level, array('id' => 'level', 'class' => 'form-control', 'min' => '0')) !!}
            </div>
            {!! Form::submit('Save', array('class' => 'btn btn-sm btn-primary hov-slide float-right')) !!}
        {!! Form::close() !!}
    </div>
@stop