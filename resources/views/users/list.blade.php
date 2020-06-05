@extends('base')

@section('content')
    <div class="row justify-content-left">
        <h2 class="lead text-muted"><i class="fas fa-users"></i> User manager</h2>
    </div>
    <div class="card">
        <div class="table-responsive-sm">
            <table class="table table-striped table-hover table-sm m-0">
                <thead class="table-bordered px-3">
                    <tr>
                        <th scope="col"><span class="badge badge-info">{{ $users->count() }}</span></th>
                        <th>Userid</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Created at</th>
                        <th><i class="fas fa-pen-square"></i></th>
                    </tr>
                </thead>
                <tbody>
            @if ($users->count() > 0)
            @foreach ($users as $num => $user)
                    <tr>
                        <th scope="row">{{ ++$num }}</th>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>
                            @if (Session::get('role') == 1 or $user->id == Auth::user()->id)
                                <div class="dropdown">
                                    <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-chevron-down"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="{{ url('users/' . $user->id . '/edit') }}"><i class="fas fa-pen-square"></i> Edit</a>
                                        <form style="display:inline;" action="{{ url('users/' . $user->id) }}" method="post" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="5">No data</td>
                    </tr>
            @endif
                </tbody>
            </table>
        </div>
    </div>
@stop