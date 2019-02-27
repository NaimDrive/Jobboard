@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <h1 class="text-center"> La suppression à était réalisée ! </h1>

    <div class="text-center mt-4">
        @if(Auth::user()->isAdmin())
            <a href="{{route('admin')}}"> <button class="btn-success"> Retour à la page d'administration</button> </a>
        @elseif(Auth::user()->isContact())
            <a href="{{route('accueil')}}"> <button class="btn-success"> Retour à la page d'accueil</button> </a>
        @endif
    </div>
@endsection
