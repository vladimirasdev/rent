@extends('base')

@section('content')
    <div class="row justify-content-start">
        <h2 class="lead text-muted"><i class="fas fa-pen-square"></i> Edit transfer</h2>
    </div>

    @if($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger mx-auto" style="max-width: 540px;">{{ $error }}</div>
        @endforeach
    @endif

    <div class="justify-content-center row">
        {!! Form::open(array('url' => 'routing/' . $route->id, 'method' => 'put')) !!}
            {{ csrf_field() }}

            <div class="form-group">
                {!! Form::label('created_at', 'Date') !!}
                {!! Form::text('created_at', $route->created_at, array('id' => 'created_at', 'class' => 'form-control')) !!}
            </div>
            <div class="row">
                <div class="form-group col-6">
                    {!! Form::label('in_out', 'Status:') !!}
                    <br/>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons" id="status">
                        <label class="btn btn-outline-info {{ $route->in_out == 'in' ? 'active focus' : '' }}">
                        <input type="radio" name="in_out" id="in_out" value="in" {{ $route->in_out == 'in' ? 'selected' : '' }}> <i class="fas fa-arrow-left"></i>
                        </label>
                        <label class="btn btn-outline-secondary {{ $route->in_out == 'hold' ? 'active focus' : '' }}">
                        <input type="radio" name="in_out" id="in_out" value="hold" {{ $route->in_out == 'hold' ? 'selected' : '' }}> <i class="fas fa-arrow-left"></i><i class="fas fa-arrow-right"></i>
                        </label>
                        <label class="btn btn-outline-warning {{ $route->in_out == 'out' ? 'active focus' : '' }}">
                        <input type="radio" name="in_out" id="in_out" value="out" {{ $route->in_out == 'out' ? 'selected' : '' }}> <i class="fas fa-arrow-right"></i>
                        </label>
                    </div>
                </div>
                <div class="form-group col-6">
                    {!! Form::label('quantity', 'Quantity') !!}
                    {!! Form::number('quantity', $route->quantity, array('id' => 'quantity', 'class' => 'form-control', 'min' => '0')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('item_code', 'Item code:') !!}
                {!! Form::text('item_code', $route->item_code, array('id' => 'item_code', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description:') !!}
                {!! Form::textarea('description', $route->description, array('id' => 'description', 'class' => 'form-control', 'rows' => '1')) !!}
            </div>
            {!! Form::submit('Save', array('class' => 'btn btn-block btn-sm btn-primary hov-slide float-right')) !!}
        {!! Form::close() !!}
    </div>
@stop