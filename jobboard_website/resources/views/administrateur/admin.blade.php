@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href=" {{ asset('https://use.fontawesome.com/releases/v5.7.2/css/all.css') }}" rel="stylesheet" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Tableau de bord </h1>
            </div>
        </div>

        <div class="row">

            <div class="card text-center col-12 col-md-3">
                <div class="card-body">
                    <h4 class="card-title">Etudiants <span class="badge badge-pill badge-dark">{{ $nbEtu }}</span> </h4>
                    @if($etudiants->isEmpty())
                        <div class="empty_foreach">
                            <p class="card-text">Aucun étudiant</p>
                        </div>
                    @else
                        <div class="foreach">
                            @foreach($etudiants as $etu)
                                <p class="card-text"> {{$etu->user->nom}}  {{$etu->user->prenom}}</p>
                            @endforeach
                        </div>
                            <a href="{{route('administrerUnEtudiant')}}" class="seemore"><i class="far fa-eye"></i></a>
                    @endif
                </div>
            </div>

            <div class="card text-center col-12 col-md-3">
                <div class="card-body">
                    <h4 class="card-title text-center">Entreprises <span class="badge badge-pill badge-dark">{{ $nbEnt }}</span> </h4>
                    @if($entreprises->isEmpty())
                        <div class="empty_foreach">
                            <p class="card-text">Aucune entreprise</p>
                        </div>
                    @else
                        @foreach($entreprises as $entreprise)
                            <div class="foreach">
                                <p class="card-text"> {{$entreprise->nom}}</p>
                            </div>
                        @endforeach
                            <a href="{{route('administrerUneEntreprise')}}" class="seemore"><i class="far fa-eye"></i></a>
                    @endif
                </div>
            </div>

            <div class="card text-center col-12 col-md-3">
                <div class="card-body">
                    <h4 class="card-title text-center">Contacts <span class="badge badge-pill badge-dark">{{ $nbCont }}</span> </h4>
                    @if($contacts->isEmpty())
                        <div class="empty_foreach">
                            <p class="card-text">Aucun contact</p>
                        </div>
                    @else
                        <div class="foreach">
                            @foreach($contacts as $contact)
                                <p class="card-text"> {{$contact->nom}} {{$contact->prenom}}</p>
                            @endforeach
                        </div>
                            <a href="{{route('administrerUnContact')}}" class="seemore"><i class="far fa-eye"></i></a>
                    @endif
                </div>
            </div>

            <div class="card text-center col-12 col-md-3">
                <div class="card-body">
                    <h4 class="card-title text-center">Offres <span class="badge badge-pill badge-dark">{{ $nbOf }}</span> </h4>
                    @if($offres->isEmpty())
                        <div class="empty_foreach">
                            <p class="card-text">Aucune offre</p>
                        </div>
                    @else
                        @foreach($offres as $offre)
                            <div class="foreach">
                                <p class="card-text"><u>{{$offre->natureOffre}}</u> - {{$offre->nomOffre}} </p>
                            </div>
                        @endforeach
                            <a href="{{route('administrerUneOffre')}}" class="seemore"><i class="far fa-eye"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection


