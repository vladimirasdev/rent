@extends('base')

@section('content')
    <div class="row justify-content-between">
        <h2 class="lead text-muted"><i class="fas fa-route"></i> Transfer items</h2>
        <a href="{{ url('routing/create') }}"><button class="btn btn-sm btn-info mb-3"><i class="fas fa-plus"></i> Transfer</button></a>
    </div>

    @if (App\Routing::where('in_out', '=', 'hold')->sum('quantity') > 0)
        <div class="row justify-content-center">
            <div class="row">
                <a href="{{ url('routing/status/in') }}" onclick="return confirm('Will be moved to IN status. Are you sure?')"><button type="button" class="btn btn-sm btn-info"><i class="fas fa-arrow-left"></i></button></a>
                <button class="btn btn-sm btn-secondary mb-3 float-right" data-toggle="modal" data-target="#changeStatusModal" disabled>
                    <i class="fas fa-arrow-left"></i>
                    <span class="badge badge-light">{{ App\Routing::where('in_out', '=', 'hold')->sum('quantity') }}</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
                <a href="{{ url('routing/status/out') }}" onclick="return confirm('Will be moved to OUT status. Are you sure?')"><button type="button" class="btn btn-sm btn-warning"><i class="fas fa-arrow-right"></i></button></a>
            </div>
        </div>
    @endif

    <div class="card mb-5">
        
        <div class="btn-group" role="group">
            <a class="btn btn-block btn-outline-secondary alert-secondary collapsed text-left" data-toggle="collapse" href="#collapseToday" role="button" aria-expanded="false" aria-controls="collapseToday">
                <span class="badge badge-light"><i class="fas fa-calendar-day"></i> Today</span>
                <span class="badge badge-light">{{ date('Y-m-d') }}</span>
                <span class="badge badge-light">{{ App\Routing::where('created_at', 'like', '%'.date('Y-m-d').'%')->where('in_out', '=', 'in')->sum('quantity') }} <span class="badge badge-info"><i class="fas fa-arrow-left"></i></span></span>
                <span class="badge badge-light">{{ App\Routing::where('created_at', 'like', '%'.date('Y-m-d').'%')->where('in_out', '=', 'out')->sum('quantity') }} <span class="badge badge-warning"><i class="fas fa-arrow-right"></i></span></span>
                <span class="badge badge-light">{{ App\Routing::where('created_at', 'like', '%'.date('Y-m-d').'%')->where('in_out', '=', 'hold')->sum('quantity') }} <span class="badge badge-secondary"><i class="fas fa-arrow-left"></i><i class="fas fa-arrow-right"></i></span></span>
            </a>
    
            <a href="{{ url('routing/list/' . date('Y-m-d')) }}">
                <button type="button" class="btn btn-sm btn-light h-100"><i class="fas fa-list"></i></button>
            </a>
        </div>
        <div class="table-responsive-sm">
            <table class="table table-striped table-hover table-sm m-0 collapse show" id="collapseToday">
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
                    @if ($routings->count() > 0)
                        @foreach ($routings as $route)
                            @if (date_format($route->created_at, 'Y-m-d') == date('Y-m-d'))
                                <tr {{ App\Items::where('item_code', $route->item_code )->first() === null ? 'class=table-warning' : '' }}>
                                    <td><a title="{{ $route->created_at }}"></span>{{ date_format($route->created_at, 'Y-m-d H:i') }}</a></td>
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
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">No data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <a class="btn btn-block btn-outline-secondary alert-secondary collapsed text-left" data-toggle="collapse" href="#collapseOldest" role="button" aria-expanded="false" aria-controls="collapseOldest">
            <span class="badge badge-light"><i class="fas fa-calendar-alt"></i> Show oldest</span>
        </a>
        
        <div class="collapse" id="collapseOldest">
            @if ($routings->count() > 0)
                <?php $datesArray = array(); ?>
                @foreach ($routings as $route)
                    @if (date_format($route->created_at, 'Y-m-d') < date('Y-m-d'))
                        <?php 
                            if (!isset($last_date)) {
                                $last_date = date_format($route->created_at, 'Y-m-d');
                                $switch = false;
                            }
                        ?>
                        @if (date_format($route->created_at, 'Y-m-d') == $last_date)
                            @if($switch == false)
                                <?php  array_push($datesArray, date_format($route->created_at, 'Y-m-d')); ?>
                                <?php $switch = true; ?>
                            @endif
                        @else
                            <?php $switch = false; ?>
                        @endif
                        <?php $last_date = date_format($route->created_at, 'Y-m-d'); ?>
                    @endif
                @endforeach
                
                <div class="grid-container" style="padding: 10px; grid-gap: 10px; grid-template-columns: repeat(auto-fit, 109px);">
                    @foreach ($datesArray as $date)
                        <a href="{{ url('routing/list/' . $date) }}" class="btn btn-outline-secondary btn-sm collapsed text-left">
                            <span class="badge badge-light"><i class="fas fa-calendar-day"></i></span>
                            <span class="badge badge-light">{{ $date }}</span>
                            <span class="badge badge-light">{{ App\Routing::where('created_at', 'like', '%'.$date.'%')->where('in_out', '=', 'in')->sum('quantity') }} <span class="badge badge-info"><i class="fas fa-arrow-left"></i></span></span>
                            <span class="badge badge-light">{{ App\Routing::where('created_at', 'like', '%'.$date.'%')->where('in_out', '=', 'out')->sum('quantity') }} <span class="badge badge-warning"><i class="fas fa-arrow-right"></i></span></span>
                        </a>
                    @endforeach
                </div>
            @else
                <div>No data</div>
            @endif            
        </div>
        
    </div>
@stop