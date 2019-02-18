<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jobboard IUT de Lens</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{  asset ('css/bootstrap.css')  }}"/>
    <link rel="stylesheet" href="{{  asset ('css/navbarD.css')  }}"/>
</head>
<body>
    @include('layouts.header')
    <div class="mt-5">
        <br>
        <br>
        @yield('content')
    </div>

    @include('layouts.footer')
    @yield('javaScript')
</body>
</html>
