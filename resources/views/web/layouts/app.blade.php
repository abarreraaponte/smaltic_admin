<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Smaltic Art</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link rel="shortcut icon" href="/img/brand/logo.png" type="image/png">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css')}}"" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/lib/DataTables/datatables.min.css"/>
</head>
<body>
    <div id="app">

        <!-- Top Bar-->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm navbar-main-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/img/brand/logo.png" width="90" height="60">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto" style="font-size: 1.1rem;">
                        <li class="nav-item ml-2">
                            <a class="nav-link" href="/web/jobs"><i class="fas fa-calendar-check"></i> {{ __('Trabajos') }}</a>
                        </li>
                        <li class="nav-item ml-2">
                            <a class="nav-link" href="/web/expenses"><i class="fas fa-receipt"></i> {{ __('Gastos') }}</a>
                        </li>
                        <li class="nav-item ml-2">
                            <a class="nav-link" href="/web/customers"><i class="fas fa-female"></i> {{ __('Clientas') }}</a>
                        </li>
                        <li class="nav-item dropdown ml-2">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="fas fa-database"></i> {{ __('Datos')}}</a>
                            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/web/artists"><i class="fas fa-angle-right"></i> {{ __('Artistas') }}</a>
                                <a class="dropdown-item" href="/web/accounts"><i class="fas fa-angle-right"></i> {{ __('Cuentas') }}</a>
                                <a class="dropdown-item" href="/web/sources"><i class="fas fa-angle-right"></i> {{ __('Como nos conoce') }}</a>
                                <a class="dropdown-item" href="/web/payment-methods"><i class="fas fa-angle-right"></i> {{ __('Medios de Pago') }}</a>
                                <a class="dropdown-item" href="/web/services"><i class="fas fa-angle-right"></i> {{ __('Servicios') }}</a>
                                <a class="dropdown-item" href="/web/expense-categories"><i class="fas fa-angle-right"></i> {{ __('Categorias de Gasto') }}</a>
                                <a class="dropdown-item" href="/web/users"><i class="fas fa-angle-right"></i> {{ __('Usuarios') }}</a>
                            </div>
                        </li>
                         {{-- <li class="nav-item ml-2">
                            <a class="nav-link" href="/web/reports"><i class="fas fa-chart-bar"></i> {{ __('Reportes') }}</a>
                        </li> --}}
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto" style="font-size: 1.1rem;">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="/web/profile" class="dropdown-item">Mi Perfil</a>
                                    <a class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @if (session('status'))
            <div class="alert alert-info" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('errors'))
            <div class="alert alert-danger" role="alert">
                {{ session('errors') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning" role="alert">
                {{ session('warning') }}
            </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="/lib/DataTables/datatables.min.js"></script>

    @yield('ps_scripts')
    @stack('list_scripts')
    @stack('form_scripts')

</body>
</html>
