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
        });
    </script>
    @yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">


</head>
<body>
    <div id="app">

        <div class="d-flex align-items-center justify-content-center p-4" style="height: 15vh">
            <img src="/images/custom/logo-lat.png" style="width: 350px"/>
        </div>

        <div style="height: 85vh">
            @yield('content')
        </div>


    </div>
</body>
</html>
