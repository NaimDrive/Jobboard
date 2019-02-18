@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <h1 class="text-center"> La suppression à était réalisée ! </h1>

    <div class="text-center mt-4">
        <a href="{{route('admin')}}"> <button class="btn-success"> Retour à la page d'administration </button> </a>
    </div>
@endsection