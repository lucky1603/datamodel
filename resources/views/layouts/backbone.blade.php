<!doctype HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NTP Accelerator - {{ __('Add New Profile')  }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- App css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
</head>
<body>
    @yield('body-content')

<!-- Scripts -->
<!-- bundle -->
<script src="/assets/js/vendor.min.js"></script>
<script src="/assets/js/app.min.js"></script>
</body>
</html>
