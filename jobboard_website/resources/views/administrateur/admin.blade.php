@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Tableau de bord </h1>

            </div>
        </div>

        <div class="row" id="ligne_admin">

            <div class="card text-center col-md-3">
                <div class="card-body">
                    <h4 class="card-title">Etudiants <span class="badge badge-pill badge-dark">{{ $nbEtu }}</span> </h4>
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

            {{--<div class="col-12 col-md-3" id="ligne_admin">
                <h3>Etudiants <span class="badge badge-pill badge-dark">{{ $nbEtu }}</span> </h3>
                @if($etudiants->isEmpty())
                    <p>Aucun étudiant</p>
                @else
                    @foreach($etudiants as $etu)
                        <strong><p> {{$etu->user->nom}}  {{$etu->user->prenom}}</p></strong>
                    @endforeach
                    <a href="{{route('administrerUnEtudiant')}}"><button class="btn-primary">Voir + </button></a>
                @endif

            </div>--}}

            <div class="col-12 col-md-3" id="ligne_admin">
                <h3>Entreprises <span class="badge badge-pill badge-dark">{{ $nbEnt }}</span></h3>
                @if($entreprises->isEmpty())
                    <p>Aucune entreprise</p>
                @else
                    @foreach($entreprises as $entreprise)
                        <strong><p>{{ $entreprise->nom }}</p></strong>
                    @endforeach
                    <a href="{{route('administrerUneEntreprise',[$entreprise->id])}}"><button class="btn-primary">Voir + </button></a>
                @endif

            </div>

            <div class="col-12 col-md-3" id="ligne_admin">
                <h3>Contacts <span class="badge badge-pill badge-dark">{{ $nbCont }}</span></h3>
                @if($contacts->isEmpty())
                    <p> Aucun contact </p>
                @else
                    @foreach($contacts as $cont)
                        <strong><p>{{ $cont->nom }} {{ $cont->prenom }}</p></strong>
                    @endforeach
                    <a href="{{route('administrerUnContact')}}"><button class="btn-primary">Voir + </button></a>
                @endif
            </div>

            <div class="col-12 col-md-3" id="ligne_admin">
                <h3>Offres <span class="badge badge-pill badge-dark">{{ $nbOf }}</span></h3>
                @if($offres->isEmpty())
                    <p>Aucune offre</p>
                @else
                    @foreach($offres as $offre)
                        <strong><p> {{ $offre->natureOffre }} {{ $offre->nomOffre }} </p></strong>
                    @endforeach
                    <a href="#"><button class="btn-primary">Voir + </button></a>
                @endif
            </div>
        </div>
    </div>

@endsection


