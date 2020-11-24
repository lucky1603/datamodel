<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="height:100%;">
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

            // const app = new Vue({
            //     el: '#app',
            // });

        });


    </script>
    @yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/style.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/my.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/jquery.ui.1.10.0.ie.css') }}" rel="stylesheet">


</head>
<body style="background-color: #f8f8f8;">
    <div id="app">
        <div id="content" >
            <nav id="mainMenu" class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">
{{--                        {{ config('app.name', 'Laravel') }}--}}
{{--                        <img src="/images/logo-lat.png" height="80"/>--}}
                        @yield('title')
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
                                @yield('returns')
                                <li class="nav-item dropdown" style="float: right">

                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <img src="{{ asset(Auth::user()->photo) }}" height="25px"/> {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <img src="/images/switch-turn-off-icon.png" style="height: 25px" title="{{__('Logout')}}"/><span style="margin-left: 15px">{{__('Logout')}}</span>
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
            <main style="position: absolute; top: 0px; bottom: 0px; left: 0px; right: 0px">
                @yield('content')
            </main>

        </div>

{{--    <script src="{{ asset('js/app.js') }}" ></script>--}}
    </div>
<script type="text/javascript">
    $(document).ready(function() {
       var navHeight = $('nav').height();
       var paddingTop = $('nav').css('padding-top');
       var paddingBottom = $('nav').css('padding-bottom');
       var marginTop = $('nav').css('margin-top');
       var marginBottom = $('nav').css('margin-bottom');
       var newPos = parseInt(navHeight) + parseInt(paddingBottom) + parseInt(paddingTop) + parseInt(marginTop) + parseInt(marginBottom);
       $('main').css('top', newPos);
    });
</script>
</body>
</html>
