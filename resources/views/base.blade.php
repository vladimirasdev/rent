<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon image -->
    <link rel="icon" href="{{ asset('images/carrot.png') }}" type="image/png">
    <!-- Fontawesome -->
    <link href="{{ asset('css/fontawesome/all.css') }}" rel="stylesheet">
    <script defer src="{{ asset('js/fontawesome/all.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('css/main.css?4') }}" />
    <!-- jQuery JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <!-- Instascan JS -->
    <script type="text/javascript" src="{{ asset('js/instascan.min.js?3') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('js/main.js?3') }}"></script>

    <title>{{ $meta_title ?? 'Rent' }}</title>
</head>

<body data-spy="scroll" data-target="#list-example" data-offset="0">

    @if (Auth::check())
        @if (isset(Auth::user()->name))
            <?php Session::put( 'role', !empty(App\Role::find(Auth::user()->id)->level) ? App\Role::find(Auth::user()->id)->level : '0' ); ?>
        @endif
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand d-block" href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" style="height: 1.625rem;"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarsExample04">
            <ul class="navbar-nav mr-auto d-md-none">
                <li class="nav-item {{ (request()->is('home*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('home') }}"><i class="fas fa-chart-bar"></i> Reports</a>
                </li>
                <li class="nav-item {{ (request()->is('items*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('items') }}"><i class="fas fa-warehouse"></i> Inventory</a>
                </li>
                <li class="nav-item {{ (request()->is('routing*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('routing') }}"><i class="fas fa-route"></i> Transfers</a>
                </li>
                <li class="nav-item {{ (request()->is('qrscanner*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('qrscanner') }}"><i class="fas fa-qrcode"></i> QR Scanner</a>
                </li>
                <li class="nav-item {{ (request()->is('category*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('category') }}"><i class="fas fa-layer-group"></i> Category</a>
                </li>
                <li class="nav-item {{ (request()->is('users*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('users') }}"><i class="fas fa-users"></i> Users</a>
                </li>
                <li class="nav-item {{ (request()->is('roles*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('roles') }}"><i class="fas fa-user-shield"></i> Roles</a>
                </li>
            </ul>
            
            {!! Form::open(array('url' => 'search', 'class' => 'form-inline my-2 my-lg-0 mr-2 ml-auto')) !!}
            {{ csrf_field() }}
            <div class="input-group form-inline">
                <div id="search-wrapper">
                    <input id="search-input" class="form-control form-control-sm" type="search" name="search"
                        placeholder="Search" aria-label="Search">
                    <button id="search-button" class="btn btn-sm btn-light border-0 my-sm-0"
                        type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
            {!! Form::close() !!}

            @if (Auth::check())
            {!! Form::open(['url' => 'logout']) !!}
            <div class="form-inline">

                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <div class="dropdown">
                        <div class="input-group">
                            <button class="btn btn-sm btn-light border-secondary dropdown-toggle"
                                type="button" id="dropdownAdmin" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}
                            </button>
                        </div>
                        
                        <div class="dropdown-menu" aria-labelledby="dropdownAdmin">
                            <a class="dropdown-item" href="{{ url('logout') }}"><i class="fas fa-sign-out-alt text-muted"></i> Sign out</a>
                        </div>
                        
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            @else
            <button type="submit" class="btn btn-sm btn-outline-dark" data-toggle="modal"
                data-target=".bd-login-modal-sm">Sign in</button>
            @endif
        </div>
    </nav>

    <div class="container-fluid mt-5">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-dark sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">

                        <li class="nav-item ">
                            <a class="nav-link text-grey {{ (request()->is('home*')) ? 'active' : '' }}" href="{{ url('home') }}"><i class="fas fa-chart-bar"></i> Reports</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-grey {{ (request()->is('items*')) ? 'active' : '' }}" href="{{ url('items') }}"><i class="fas fa-warehouse"></i> Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-grey {{ (request()->is('routing*')) ? 'active' : '' }}" href="{{ url('routing') }}"><i class="fas fa-route"></i> Transfers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-grey {{ (request()->is('qrscanner*')) ? 'active' : '' }}" href="{{ url('qrscanner') }}"><i class="fas fa-qrcode"></i> QR Scanner</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-grey {{ (request()->is('category*')) ? 'active' : '' }}" href="{{ url('category') }}"><i class="fas fa-layer-group"></i> Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-grey {{ (request()->is('users*')) ? 'active' : '' }}" href="{{ url('users') }}"><i class="fas fa-users"></i> Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-grey {{ (request()->is('roles*')) ? 'active' : '' }}" href="{{ url('roles') }}"><i class="fas fa-user-shield"></i> Roles</a>
                        </li>
                    </ul>
                </div>
            </nav>
      
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 pb-4">
                <div class="row justify-content-end pt-3">
                    <ul class="nav flex-row d-lg-none">
                        <li class="nav-item">
                            <div class="btn-group nav-link" role="group" aria-label="Basic example">
                                <a class="text-grey {{ (request()->is('routing*')) ? 'active' : '' }}" href="{{ url('routing/create') }}" title="Transfers"><button class="btn btn-outline-secondary"><i class="fas fa-plus"></i></button></a>
                                <a class="text-grey {{ (request()->is('routing*')) ? 'active' : '' }}" href="{{ url('routing') }}" title="Transfers"><button class="btn btn-outline-secondary"><i class="fas fa-route"></i></button></a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-grey {{ (request()->is('items*')) ? 'active' : '' }}" href="{{ url('items') }}" title="Inventory"><button class="btn btn-outline-secondary"><i class="fas fa-warehouse"></i></button></a>
                        </li>
                    </ul>
                    
                </div>
                <!-- Content -->
                <content>
                    @yield('content')
                </content>
          </main>
        </div>
    </div>

    @elseif (Auth::guest())
        @if (request()->is('register*'))
            <div class="container mt-3">
                @if ($errors->any())
                    <div class="alert alert-danger mx-auto" style="max-width: 540px;">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    </div>
                @endif
                <p><h2 class="text-center text-black-50">Register</h2></p>
                <div class="row justify-content-center">
                    {!! Form::open(['url' => 'register']) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Username:') !!}
                            {!! Form::text('name', old('name'), array('id' => 'name', 'class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::email('email', old('email'), array('id' => 'email', 'class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('password', 'Password:') !!}
                            {!! Form::password('password', array('id' => 'password', 'class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'Repeat password:') !!}
                            {!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control')) !!}
                        </div>
                        <button type="submit" class="btn btn-block btn-primary">Sign up</button>
                    {!! Form::close() !!}
                </div>
            </div>
        @else
            <div class="row justify-content-center my-auto">
                <div class="card" style="width: 18rem;">
                    {!! Form::open(['url' => 'login']) !!}
                    <div class="card-body rounded bg-light text-dark">
                        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                        <div class="form-group">
                            {!! Form::label('email', 'E-mail address:') !!}
                            {!! Form::email('email', old('email'), array('id' => 'email', 'class' => 'form-control'))
                            !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('password', 'Password:') !!}
                            {!! Form::password('password', array('id' => 'password', 'class' => 'form-control')) !!}
                        </div>
                        <button type="submit" class="btn btn-block btn-primary">Sign in</button>
                    </div>
                    {!! Form::close() !!}
                    <div class="card-footer p-0 pb-2">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('register') }}">New around here? Sign up</a>
                        <a class="dropdown-item" href="{{ url('reset') }}">Forgot password?</a>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

</body>

</html>