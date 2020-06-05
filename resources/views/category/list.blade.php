@extends('base')

@section('content')
    <div class="row justify-content-between">
        <h2 class="lead text-muted"><i class="fas fa-layer-group"></i> Category</h2>
        <a href="{{ url('category/create') }}"><button class="btn btn-sm btn-info mb-3"><i class="fas fa-plus"></i> Category</button></a>
    </div>
    
    <div class="card">
        <div class="table-responsive-sm">
            <table class="table table-striped table-hover table-sm m-0">
                <thead class="table-bordered px-3">
                    <tr>
                        <th scope="col"><span class="badge badge-info">{{ $categories->count() }}</span></th>
                        <th>Title</th>
                        <th>Description</th>
                        <th><i class="fas fa-pen-square"></i></th>
                    </tr>
                </thead>
                <tbody>
                @if ($categories->count() > 0)
                    @foreach ($categories as $num => $category)
                        <tr>
                            <th scope="row">{{ ++$num }}</th>
                            <td>{{ $category->title }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                @if (Session::get('role') == 1 or Session::get('role') == 2)
                                    <div class="dropdown">
                                        <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-chevron-down"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="{{ url('category/' . $category->id . '/edit') }}"><i class="fas fa-pen-square"></i> Edit</a>
                                            <form style="display:inline;" action="{{ url('category/' . $category->id) }}" method="post" onsubmit="return confirm('Are you sure?')">
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
                            <td colspan="4">No data</td>
                        </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@stop