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
    @yield('css')
</head>
<body>
    @include('layouts.header')
    <div class="mt-5">
        <br>
        @yield('content')
    </div>

    @include('layouts.footer')
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=xapyjagfjtw5wa5samm0vvsuul6ig9f0bg2slvs0udyuapli"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @yield('javaScript')
</body>
</html>
