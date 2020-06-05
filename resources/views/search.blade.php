@extends('base')

@section('content')
    <div class="row justify-content-left">
        <h2 class="lead text-muted"><i class="fas fa-search"></i> Search result</h2>
    </div>
    @if ($items->count() > 0)
        <div class="row justify-content-center mb-3">
            For search request "<strong>{{ $search ?? "" }}</strong>" found:
        </div>
        <div class="card mb-5">
            <div class="table-responsive-sm">
                <table class="table table-striped table-sm m-0">
                    <thead>
                        <tr>
                            <th scope="col"><span class="badge badge-info">{{ $items->count() }}</span></th>
                            <th>Code</th>
                            <th>Quantity</th>
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
                    @if ($items->count() > 0)
                        @foreach ($items as $num => $item)
                            <tr class="{{ $item->issue == 'on' ? 'table-danger' : '' }}">
                                <th scope="row">{{ ++$num }}</th>
                                <td><a class="text-dark" href="{{ url('item/' . $item->item_code) }}">{{ $item->item_code }}</a></td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->category->title }}</td>
                                <td>{{ $item->manufacture }}</td>
                                <td>{{ $item->model }}</td>
                                <td>{{ $item->serial_number }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ App\User::find($item->user_id)->name }}</td>
                                <td>
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
                                </td>
                            </tr>
                        @endforeach
                    @else
                            <tr>
                                <td colspan="10">No data</td>
                            </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="row justify-content-center">
            Sorry, for search request "<strong>{{ $search ?? "" }}</strong>" Nothing found.
        </div>
    @endif

    <div class="card mb-5">
        <div class="table-responsive-sm">
            <table class="table table-striped table-sm m-0 collapse show" id="collapseToday">
                <thead class="table-bordered px-3">
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Qty</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Username</th>
                        <th><i class="far fa-edit"></i></th>
                    </tr>
                </thead>
                
                <tbody>
                    @if ($itemsTransfer->count() > 0)
                        @foreach ($itemsTransfer as $route)
                            <tr>
                                <td><a title="{{ $route->created_at }}"></span>{{ date_format($route->created_at, 'Y-m-d H:m') }}</a></td>
                                <td>
                                    <span class="badge 
                                        {{ $route->in_out == 'in' ? 'badge-info' : '' }}
                                        {{ $route->in_out == 'hold' ? 'badge-secondary' : '' }}
                                        {{ $route->in_out == 'out' ? 'badge-warning' : '' }}
                                        ">
                                        {!! $route->in_out == 'in' ? '<i class="fas fa-arrow-left"></i>' : '' !!}
                                        {!! $route->in_out == 'hold' ? '<i class="fas fa-arrow-left"></i><i class="fas fa-arrow-right"></i>' : '' !!}
                                        {!! $route->in_out == 'out' ? '<i class="fas fa-arrow-right"></i>' : '' !!}
                                    </span>
                                </td>
                                <td>{{ $route->quantity }}</td>
                                <td><a class="text-dark" href="{{ url('item/' . $route->item_code) }}">{{ $route->item_code }}</a></td>
                                <td>{{ $route->description }}</td>
                                <td>{{ App\User::find($route->user_id)->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-chevron-down"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="{{ url('routing/' . $route->id . '/edit') }}"><i class="fas fa-edit"></i> Edit</a>
                                            <form style="display:inline;" action="{{ url('routing/' . $route->id) }}" method="post" onsubmit="return confirm('Are you sure?')">
                                                <input type="hidden" name="_method" value="DELETE" />
                                                {{ csrf_field() }}
                                                <button type="submit" class="dropdown-item" value="Delete"><i class="fas fa-trash-alt"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">No data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop
