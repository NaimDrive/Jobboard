<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jobboard IUT de Lens</title>
<<<<<<< HEAD
=======
    <link rel="icon" type="image.png" href="images/Logo-Reversed-Brain-solo.ico"/>
    <title>Reversed Brain</title>
>>>>>>> 3af831534ef375fe6d55d443ca35da8eadbb70b1
    <!-- Styles -->
    <link rel="stylesheet" href="{{  asset ('css/bootstrap.css')  }}"/>
</head>
<body>
    @include('layouts.header')
    @yield('content')
    @include('layouts.footer')
</body>
</html>