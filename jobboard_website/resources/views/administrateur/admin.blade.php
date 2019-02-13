@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Tableau de bord </h1>

            </div>
        </div>

        <div class="row" id="ligne_admin">
            <div class="col-12 col-md-3" id="ligne_admin">
                <h3>Etudiants <span class="badge badge-pill badge-dark">{{ $nbEtu }}</span> </h3>
                @if($etudiants->isEmpty())
                    <p>Aucune entreprise</p>
                @else
                    @foreach($etudiants as $etu)
                        <p> {{$etu->nom}}  {{$etu->prenom}}</p>
                    @endforeach
                @endif
                <a href="{{route('administrerUnEtudiant')}}"><button class="btn-primary">Voir + </button></a>
            </div>

            <div class="col-12 col-md-3" id="ligne_admin">
                <h3>Entreprises <span class="badge badge-pill badge-dark">{{ $nbEnt }}</span></h3>
                @if($entreprises->isEmpty())
                    <p>Aucune entreprise</p>
                @else
                    @foreach($entreprises as $entreprise)
                        <p>{{ $entreprise->nom }}</p>
                    @endforeach
                @endif
                <a href="{{route('administrerUneEntreprise')}}"><button class="btn-primary">Voir + </button></a>
            </div>

            <div class="col-12 col-md-3" id="ligne_admin">
                <h3>Contacts <span class="badge badge-pill badge-dark">{{ $nbCont }}</span></h3>
                @if($contacts->isEmpty())
                    <p> Aucun contact </p>
                @else
                    @foreach($contacts as $cont)
                        <p>{{ $cont->nom }} {{ $cont->prenom }}</p>
                    @endforeach
                @endif
                <button class="btn-primary">Voir + </button>
            </div>

            <div class="col-12 col-md-3" id="ligne_admin">
                <h3>Offres <span class="badge badge-pill badge-dark">{{ $nbOf }}</span></h3>
                @if($offres->isEmpty())
                    <p>Aucune offre</p>
                @else
                    @foreach($offres as $offre)
                        <p> {{ $offre->natureOffre }} {{ $offre->nomOffre }} </p>
                    @endforeach
                @endif
                <button class="btn-primary"><a href="#"></a>Voir + </button>
            </div>
        </div>
    </div>

@endsection


