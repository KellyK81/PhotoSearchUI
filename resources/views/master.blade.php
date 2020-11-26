<!doctype html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8">
        <title>HomePage</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" id="bootstrap-css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ asset('css/main.css?v=1.04') }}">
        @if (Route::currentRouteName() == 'login')
            <link rel="stylesheet" href="{{ asset('css/login.css?v=1.04') }}">
        @else
            <link rel="stylesheet" href="{{ asset('css/app.css?v=1.04') }}">
            <link rel="stylesheet" href="{{ asset('css/search.css?v=1.04') }}">
        @endif
    </head>
    <body>
        <header>
            @section('header')
                @include('header')
            @show
        </header>
        
        <div id="body">
            @yield('body')
        </div>
        
        @section('footer')
            @include('footer')
        @show
    </body>
</html>