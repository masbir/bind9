<!DOCTYPE html>
<html lang="en" class="full">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'HEROIC')</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet"> 
    <script>
        var base_url = '{{ \Config::get("app.url") }}';
    </script>
</head>
<body> 

    @yield('content')

    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="/js/tracker.js"></script>
</body>
</html>
