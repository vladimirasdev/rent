@extends('base')

@section('content')
    <div class="row justify-content-start">
        <h2 class="lead text-muted"><i class="fas fa-user-shield"></i> Set user role</h2>
    </div>

    @if($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger mx-auto" style="max-width: 540px;">{{ $error }}</div>
        @endforeach
    @endif

    <div class="justify-content-center row">
        {!! Form::open(array('url' => 'roles', 'class' => 'w-50 mb-3')) !!}
        {{ csrf_field() }}
            <div class="form-group">
                {!! Form::label('id', 'Username:') !!}
                <select name="id" class="form-control">
                    @if ($users->count() > 0)
                        <?php $num = $users->count(); ?>
                        @foreach ($users as $key => $user)
                            @if (!isset( App\Role::find($user->id)->id ))
                                <option value="{{ $user->id }}" {{ $key == 0 ? 'selected' : '' }} >{{ $user->name }}</option>
                            @else
                                <?php --$num; ?>
                            @endif
                        @endforeach
                    @endif
                </select>

                <div class="form-group">
                    {!! Form::label('level', 'Level:') !!}
                    {!! Form::number('level', '1', array('id' => 'level', 'class' => 'form-control', 'min' => '0')) !!}
                </div>
            </div>
            @if($num != 0)
                {!! Form::submit('Save', array('class' => 'btn btn-sm btn-primary hov-slide float-right')) !!}
            @else
                <p class="text-center">There no users without role.</p>
            @endif
        {!! Form::close() !!}
    </div>
@stop