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

<link href="{{ asset('css/404.css') }}" rel="stylesheet">
</head>
<body >
    <h1 class="titre">OOPS</h1>
    <p class="sous">404-Page inéxistante</p>
    <input class="button" type="button" onclick="location.href='/';" value="Retour à l'accueil" />
    @yield('javaScript')
</body>


