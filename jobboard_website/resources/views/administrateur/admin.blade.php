@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href=" {{ asset('https://use.fontawesome.com/releases/v5.7.2/css/all.css') }}" rel="stylesheet" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <div class="container-fluid text-center" id="conteneur-fluide">
        <div class="row">
            <div class="col-12">
                <div class="banniere">
                    <h1> Tableau de bord </h1>
                </div>
            </div>
        </div>

        <div class="row" id="cartes">
            <div class="card text-center col-md-3" id="carte">
                <h4 class="titre">Étudiants <span class="badge badge-pill badge-dark">{{ $nbEtu }}</span></h4>
                <div class="card-body" id="foreach">
                    @if($etudiants->isEmpty())
                        <p class="card-text">Aucun étudiant</p>
                    @else
                        @foreach($etudiants as $etu)
                            <p class="card-text"> {{$etu->user->nom}}  {{$etu->user->prenom}}</p>
                        @endforeach
                </div>
                        <a href="{{route('administrerUnEtudiant')}}" class="seemore"><i class="far fa-eye"></i></a>
                    @endif
            </div>

            <div class="card text-center col-md-3" id="carte">
                <h4 class="titre">Entreprises <span class="badge badge-pill badge-dark">{{ $nbEnt }}</span></h4>
                <div class="card-body" id="foreach">
                    @if($entreprises->isEmpty())
                        <p class="card-text">Aucune entreprise</p>
                    @else
                        @foreach($entreprises as $entreprise)
                            <p class="card-text">{{ $entreprise->nom }}</p>
                        @endforeach
                </div>
                        <a href="{{route('administrerUneEntreprise')}}" class="seemore"><i class="far fa-eye"></i></a>
                    @endif
            </div>

            <div class="card text-center col-md-3" id="carte">
                <h4 class="titre">Contacts <span class="badge badge-pill badge-dark">{{ $nbCont }}</span></h4>
                <div class="card-body" id="foreach">
                    @if($contacts->isEmpty())
                        <p class="card-text"> Aucun contact </p>
                    @else
                        @foreach($contacts as $cont)
                            <p class="card-text">{{ $cont->nom }} {{ $cont->prenom }}</p>
                        @endforeach
                </div>
                        <a href="{{route('administrerUnContact')}}" class="seemore"><i class="far fa-eye"></i></a>
                    @endif
            </div>

            <div class="card text-center col-md-3" id="carte">
                <h4 class="titre">Offres <span class="badge badge-pill badge-dark">{{ $nbOf }}</span></h4>
                <div class="card-body" id="foreach">
                    @if($offres->isEmpty())
                        <p class="card-text">Aucune offre</p>
                    @else
                        @foreach($offres as $offre)
                            <p class="card-text"> {{ $offre->natureOffre }} {{ $offre->nomOffre }} </p>
                        @endforeach
                </div>
                        <a href="{{route('administrerUneOffre')}}" class="seemore"><i class="far fa-eye"></i></a>
                    @endif
            </div>
        </div>
    </div>

@endsection


