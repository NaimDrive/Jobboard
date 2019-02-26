@extends('layouts.master')

@section('content')
    <link href="{{ asset('css/404.css') }}" rel="stylesheet">


    <div class="container text-center mt-7">
        <h1 class="titre">OOPS</h1>
        
        <p class="col-7 mx-auto text-center sous">404-Page inéxistante</p>
        <br>
        <br>

        <input class="col-7 mx-auto text-center sous boutton"  type="button" onclick="location.href='/';" value="Retour à l'accueil" />
    @yield('javaScript')
    </div>
    
       


    @endsection

