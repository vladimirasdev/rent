@extends('base')

@section('content')
    <div class="row justify-content-between">
        <h2 class="lead text-muted"><i class="fas fa-user-shield"></i> Users roles</h2>
        <a href="{{ url('roles/create') }}"><button class="btn btn-sm btn-info mb-3"><i class="fas fa-plus"></i> Role</button></a>
    </div>

    <div class="card">
        <table class="table table-striped table-hover table-sm m-0">
            <thead class="table-bordered px-3">
                <tr>
                    <th scope="col"><span class="badge badge-info">{{ $roles->count() }}</span></th>
                    <th>Username</th>
                    <th>Level</th>
                    <th><i class="fas fa-pen-square"></i></th>
                </tr>
            </thead>
            <tbody>
                @if ($roles->count() > 0)
                @foreach ($roles as $num => $role)
                        <tr>
                            <th scope="row">{{ ++$num }}</th>
                            <td>{{ App\User::find($role->id)->name }}</td>
                            <td>{{ $role->level }}</td>
                            <td>
                                @if (Session::get('role') == 1)
                                    <div class="dropdown">
                                        <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-chevron-down"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="{{ url('roles/' . $role->id . '/edit') }}"><i class="fas fa-pen-square"></i> Edit</a>
                                            <form style="display:inline;" action="{{ url('roles/' . $role->id) }}" method="post" onsubmit="return confirm('Are you sure?')">
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
@stop