@extends('layouts.master')

@section('content')
    <div class="container">
        <h1 class="text-center">{{$entreprise->nom}}</h1>
        <p class="text-center">{{$entreprise->siret}}</p>

    </div>
@endsection