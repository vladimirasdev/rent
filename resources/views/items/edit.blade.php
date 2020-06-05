@extends('base')

@section('content')
    <div class="row justify-content-start">
        <h2 class="lead text-muted"><i class="fas fa-pen-square"></i> Edit item</h2>
    </div>

    @if($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger mx-auto" style="max-width: 540px;">{{ $error }}</div>
        @endforeach
    @endif

    <div class="justify-content-center row">
        {!! Form::open(array('url' => 'items/' . $item->id, 'method' => 'put')) !!}
            {{ csrf_field() }}
            <div class="form-group">
                {!! Form::label('item_code', 'Item code:') !!}
                {!! Form::text('item_code', $item->item_code, array('id' => 'item_code', 'class' => 'form-control')) !!}
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        {!! Form::label('quantity', 'Quantity:') !!}
                        {!! Form::number('quantity', $item->quantity, array('id' => 'quantity', 'class' => 'form-control', 'min' => '0')) !!}
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        {!! Form::label('issue', 'Status') !!}
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-outline-danger {{ $item->issue == 'on' ? 'active' : '' }}">
                                <input type="checkbox" name="issue" {{ $item->issue == 'on' ? 'checked' : '' }}> Issue
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('category', 'Category:') !!}
                <select name="category" class="form-control">
                    @if ($categories->count() > 0)
                        @foreach ($categories as $key => $category)
                            <option value="{{ $category->id }}" {{ $category->id == $item->category_id ? 'selected' : '' }} >{{ $category->title }} ({{ $category->description }})</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                {!! Form::label('manufacture', 'Manufacture') !!}
                {!! Form::text('manufacture', $item->manufacture, array('id' => 'manufacture', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('model', 'Model') !!}
                {!! Form::text('model', $item->model, array('id' => 'model', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('serial_number', 'Serial number') !!}
                {!! Form::text('serial_number', $item->serial_number, array('id' => 'serial_number', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description:') !!}
                {!! Form::textarea('description', $item->description, array('id' => 'description', 'class' => 'form-control', 'rows' => '2')) !!}
            </div>
            {!! Form::submit('Save', array('class' => 'btn btn-block btn-sm btn-primary hov-slide float-right')) !!}
        {!! Form::close() !!}
    </div>
@stop