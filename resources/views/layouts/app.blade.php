<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Taskky') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Jquery 3.6.0 -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simple-sidebar.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand navbar-dark bg-primary">
            <a href="{{ url('/') }}" class="navbar-brand">
                <img src="{{ asset('icons/icon-white.svg') }}" width="30px" height="30px">
                {{ config('app.name', 'Taskky') }}
            </a>


            @if(Auth::user())
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                
                <ul class="navbar-nav ml-auto">
                    <!--User Options-->
                    <div class="btn-group dropleft">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('icons/user.png') }}" width="30px" height="30px">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                <img src="{{ asset('icons/usuario.svg') }}" width="20px" height="20px">
                                Profile
                            </a>
                            {{--
                            <a class="dropdown-item" href="#">
                                <img src="{{ asset('icons/settings.svg') }}" width="20px" height="20px">
                                Settings
                            </a>
                            
                            <div class="dropdown-item custom-control custom-switch ml-4">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1">Dark mode</label>
                            </div>
                            --}}
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <img src="{{ asset('icons/exit.svg') }}" width="20px" height="20px">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </ul>
            </div>
            @endif
        </nav>

        <main class="py-0">
            @yield('content')
        </main>
    </div>
</body>

</html>