@extends('layouts.master')

@section('content')
    <div class="container">
        <h1 class="ml-2">{{$offre->nomOffre}}</h1>
        <p>{{$offre->datePublicationOffre}}</p>

        <div class="row mt-3">
            <div class="card col-md-8 ">
                <h2 class="card-header">Description</h2>
                <div class="card-body">

                    <a href="{{ route("afficherUneEntreprise",["id" => $offre->entreprise->id]) }}"> <strong>{{$offre->entreprise->nom}} </strong></a>
                    <p>Nature de l'offre : {{$offre->natureOffre}}</p>
                    <p>Du {{ $offre->dateDebut }} au {{ $offre->dateFin }}</p>
                        <p class="text-justify">Contexte : {{$offre->description->contexte}} <br>
                        Objectif : {{$offre->description->objectif}}</p>
                </div>
            </div>

            @if($offre->depot != null && $offre->lienOffre != null)
                <div class="card col-md-4">
                    <h2 class="card-header"></h2>
                </div>
            @endif
        </div>

    </div>
@endsection