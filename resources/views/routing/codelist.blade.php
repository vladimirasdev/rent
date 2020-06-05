@extends('base')

@section('content')
    <div class="row justify-content-between">
        <h2 class="lead text-muted"><i class="fas fa-route"></i> Transfered items</h2>
    </div>
    
    <div class="card">
        <div class="table-responsive-sm">
            <table class="table table-striped table-hover table-sm m-0 collapse show">
                <thead class="table-bordered px-3">
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Qty</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>Username</th>
                        <th><i class="fas fa-pen-square"></i></th>
                    </tr>
                </thead>
                
                <tbody>
                    @if ($transferList->count() > 0)
                        @foreach ($transferList as $route)
                            <tr {{ App\Items::where('item_code', $route->item_code )->first() === null ? 'class=table-warning' : '' }}>
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
                                <td class="{{ App\Items::where('item_code', '=', $route->item_code)->where('issue', '=', 'on')  == 'on' ? 'text-danger' : '' }}"><a class="text-dark" href="{{ url('item/' . $route->item_code) }}">{{ $route->item_code }}</a></td>
                                <td>{{ $route->description }}</td>
                                <td>{{ App\User::find($route->user_id)->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-chevron-down"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="{{ url('routing/' . $route->id . '/edit') }}"><i class="fas fa-pen-square"></i> Edit</a>
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
        <div>
    </div>

    <div class="row justify-content-center">
        @if ($transferList->count() > 0)
            <div class="card mx-2 mb-3" style="width: 18rem; max-height: 22.5rem;">
                <div class="card-header bg-info text-light text-center pb-0">
                    <h5 class="card-title float-left"><i class="fas fa-arrow-left"></i></h5>
                    <button type="button" class="btn btn-sm btn-light float-right" onclick="copyToClipboard('#list_in')">Copy</button>
                </div>
                <div class="card-body" style="max-height: 22.5rem; overflow-y: scroll;">
                    <p class="card-text" id="list_in">
                        @foreach ($transferList as $list1)
                            @if ($list1->in_out == "in")
                                {{ $list1->item_code }}<br/>
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>

            <div class="card mx-2 mb-3" style="width: 18rem; max-height: 22.5rem;">
                <div class="card-header bg-warning text-center pb-0">
                    <h5 class="card-title float-left"><i class="fas fa-arrow-right"></i></h5>
                    <button type="button" class="btn btn-sm btn-light float-right" onclick="copyToClipboard('#list_out')">Copy</button>
                </div>
                <div class="card-body" style="max-height: 22.5rem; overflow-y: scroll;">
                    <p class="card-text" id="list_out">
                        @foreach ($transferList as $list2)
                            @if ($list2->in_out == "out")
                                {{ $list2->item_code }}<br/>
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>

            <div class="card mx-2 mb-3" style="width: 18rem; max-height: 22.5rem;">
                <div class="card-header bg-secondary text-light text-center pb-0">
                    <h5 class="card-title float-left"><i class="fas fa-arrow-left"></i><i class="fas fa-arrow-right"></i></h5>
                    <button type="button" class="btn btn-sm btn-light float-right" onclick="copyToClipboard('#list_hold')">Copy</button>
                </div>
                <div class="card-body" style="max-height: 22.5rem; overflow-y: scroll;">
                    <p class="card-text" id="list_hold">
                        @foreach ($transferList as $list)
                            @if ($list->in_out == "hold")
                                {{ $list->item_code }}<br/>
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>
        @endif
    </div>

@stop