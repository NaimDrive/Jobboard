@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Tableau de bord </h1>

            </div>
        </div>

        <div class="row">

            <div class="card text-center col-12 col-md-3">
                <div class="card-body">
                    <h4 class="card-title text-center">Etudiants <span class="badge badge-pill badge-dark">{{ $nbEtu }}</span> </h4>
                    @if($etudiants->isEmpty())
                        <p class="card-text">Aucun étudiant</p>
                    @else
                        @foreach($etudiants as $etu)
                            <p class="card-text"> {{$etu->user->nom}}  {{$etu->user->prenom}}</p>
                        @endforeach
                        <a href="{{route('administrerUnEtudiant')}}"><button class="btn-primary">Voir + </button></a>
                    @endif
                </div>
            </div>

            <div class="card text-center col-12 col-md-3">
                <div class="card-body">
                    <h4 class="card-title text-center">Entreprises <span class="badge badge-pill badge-dark">{{ $nbEnt }}</span> </h4>
                    @if($entreprises->isEmpty())
                        <p class="card-text">Aucune entreprise</p>
                    @else
                        @foreach($entreprises as $entreprise)
                            <p class="card-text"> {{$entreprise->nom}}</p>
                        @endforeach
                        <a href="{{route('administrerUneEntreprise')}}"><button class="btn-primary">Voir + </button></a>
                    @endif
                </div>
            </div>

            <div class="card text-center col-12 col-md-3">
                <div class="card-body">
                    <h4 class="card-title text-center">Contacts <span class="badge badge-pill badge-dark">{{ $nbCont }}</span> </h4>
                    @if($contacts->isEmpty())
                        <p class="card-text">Aucun contact</p>
                    @else
                        @foreach($contacts as $contact)
                            <p class="card-text"> {{$contact->nom}} {{$contact->prenom}}</p>
                        @endforeach
                        <a href="{{route('administrerUnContact')}}"><button class="btn-primary">Voir + </button></a>
                    @endif
                </div>
            </div>

            <div class="card text-center col-12 col-md-3">
                <div class="card-body">
                    <h4 class="card-title text-center">Offres <span class="badge badge-pill badge-dark">{{ $nbOf }}</span> </h4>
                    @if($offres->isEmpty())
                        <p class="card-text">Aucune offre</p>
                    @else
                        @foreach($offres as $offre)
                            <p class="card-text"> {{$offre->nomOffre}} {{$offre->natureOffre}}</p>
                        @endforeach
                        <a href="{{route('administrerUneOffre')}}"><button class="btn-primary">Voir + </button></a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection


