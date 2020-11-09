<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/jquery-1.12.4.js') }}" ></script>
    <script src="{{ asset('js/jquery-ui.js') }}" ></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.datepicker').datepicker({
                changeMonth:true,
                changeYear:true,
                dateFormat:'yy-mm-dd'
            });

            const app = new Vue({
                el: '#app',
            });

        });


    </script>
    @yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">


</head>
<body>
    <div id="app">
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="images/HP-Startup-icon.png" width="100%"/>
                <h3 style="text-align: center;margin-top: 40px">{{ __('Accelerator') }}</h3>
            </div>
            <ul id="links_list" class="list-unstyled components" style="text-align: center">
                <li id="link_home" class="active">
                    <a href="{{ route('home') }}">{{ __('Home') }}</a>
                </li>
                <li id="link_clients"><a href="{{ route('clients.index') }}">{{ __('Clients') }}</a></li>
                <li id="link_contracts"><a href="{{ route('contracts.index') }}">{{ __('Contracts') }}</a></li>
                <li id="link_else"><a href="#">{{ __('Else') }}</a></li>
            </ul>
        </nav>
        <div id="content">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">
{{--                        {{ config('app.name', 'Laravel') }}--}}
                        <img src="images/logo-lat.png" height="80"/>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
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
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
{{--    <script src="{{ asset('js/app.js') }}" ></script>--}}
    </div>
</body>
</html>
