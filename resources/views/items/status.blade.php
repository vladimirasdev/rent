@extends('base')

@section('content')
    <div class="row justify-content-between">
        <h2 class="lead text-muted"><i class="fas fa-warehouse"></i> Inventory items</h2>
        <div class="btn-group" role="group" aria-label="Basic example">
            <div class="btn-group mr-3" role="group" aria-label="Basic example">
                <a href="{{ url('items/status/in') }}"><button type="button" class="btn btn-outline-info btn-sm"><i class="fas fa-arrow-left"></i></button></a>
                <a href="{{ url('items/status/hold') }}"><button type="button" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left"></i><i class="fas fa-arrow-right"></i></button></a>
                <a href="{{ url('items/status/out') }}"><button type="button" class="btn btn-outline-warning btn-sm"><i class="fas fa-arrow-right"></i></button></a>
            </div>
            <a href="{{ url('items/create') }}"><button class="btn btn-sm btn-info mb-3"><i class="fas fa-plus"></i> Item</button></a>
        </div>
    </div>
    <div class="card mb-5">
        <div class="table-responsive-sm">
            <table class="table table-striped table-hover table-sm m-0">
                <thead class="table-bordered px-3">
                    <tr>
                        <th scope="col"></th>
                        <th><span class="badge badge-info">{{ count($items) }}</span></th>
                        <th>Code</th>
                        <th>Status</th>
                        <th>Qty</th>
                        <th>Category</th>
                        <th>Manufacture</th>
                        <th>Model</th>
                        <th>Serial number</th>
                        <th>Description</th>
                        <th>Username</th>
                        <th><i class="fas fa-pen-square"></i></th>
                    </tr>
                </thead>
                <tbody>
                @isset ($items)
                    <?php $num = 0; ?>
                    @foreach ($items as $item)
                        <tr class="{{ $item->issue == 'on' ? 'table-danger' : '' }}">
                            <th scope="row">
                                <div class="checkbox-rect">
                                    <input type="checkbox" id="checkbox-rect-{{ $num }}" name="check">
                                    <label for="checkbox-rect-{{ $num }}"></label>
                                </div>
                            </th>
                            <th>{{ ++$num }}</th>
                            <td><a class="text-dark" href="{{ url('item/' . $item->item_code) }}">{{ $item->item_code }}</a></td>
                            <td>
                                <?php $obj = App\Routing::where('item_code', $item->item_code)->orderBy('created_at', 'desc')->first(); ?>
                                
                                @if (isset($obj) && $obj["in_out"] == 'in')
                                    <a title="{{ $obj["created_at"] }}"><span class="badge badge-info"><i class="fas fa-arrow-left"></i></span></a>
                                @elseif (isset($obj) && $obj["in_out"] == 'hold')
                                    <a title="{{ $obj["created_at"] }}"><span class="badge badge-secondary"><i class="fas fa-arrow-left"></i><i class="fas fa-arrow-right"></i></span></a>
                                @elseif (isset($obj) && $obj["in_out"] == 'out')
                                    <a title="{{ $obj["created_at"] }}"><span class="badge badge-warning"><i class="fas fa-arrow-right"></i></span></a>
                                @endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->category->title }}</td>
                            <td>{{ $item->manufacture }}</td>
                            <td>{{ $item->model }}</td>
                            <td>{{ $item->serial_number }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ App\User::find($item->user_id)->name }}</td>
                            <td>
                                @if (Session::get('role') == 1 or Session::get('role') == 2)
                                    <div class="dropdown">
                                        <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-chevron-down"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="{{ url('items/' . $item->id . '/edit') }}"><i class="fas fa-pen-square"></i> Edit</a>
                                            <form style="display:inline;" action="{{ url('items/' . $item->id) }}" method="post" onsubmit="return confirm('Are you sure?')">
                                                <input type="hidden" name="_method" value="DELETE" />
                                                {{ csrf_field() }}
                                                <button type="submit" class="dropdown-item" value="Delete"><i class="fas fa-trash-alt"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                        <tr>
                            <td colspan="10">No data</td>
                        </tr>
                @endisset
                </tbody>
            </table>
        </div>
    </div>
@stop