@extends('layouts.master')

@section('content')
    <div class="container">
        <h1 class="ml-2">{{$offre->nomOffre}}</h1>
        <p class="ml-4">Publiée le : {{ date('d/m/Y',strtotime($offre->datePublicationOffre)) }}</p>

        <div class="row mt-3">
            <div class="col-md-8">
                <div class="card">
                    <h1 class="card-header">Description</h1>
                    <div class="card-body">

                        <a href="{{ route("afficherUneEntreprise",["id" => $offre->entreprise->id]) }}"> <strong>{{$offre->entreprise->nom}} </strong></a>
                        <p>adresse du stage : <strong>{{ $offre->description->adresse->nomRue }} - {{ $offre->description->adresse->coordonnePostales }} {{ $offre->description->adresse->ville }}</strong></p>
                        <p>Nature de l'offre : {{$offre->natureOffre}}</p>
                        <p>Du {{ date('d/m/Y',strtotime($offre->dateDebut)) }} au {{ date('d/m/Y',strtotime($offre->dateFin)) }}</p>
                        <p class="text-justify">Contexte : {!! $offre->description->contexte !!} <br>
                            Objectif : {!! $offre->description->objectif !!}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <h2 class="card-header">Liens vers l'annonce</h2>
                    <div class="card-body">
                        <p>Lien vers l'annonce :</p>
                        @if($offre->lienOffre == null)
                            <p class="alert alert-warning">cette annonce n'a pas de lien</p>
                        @else
                            <a href="{{ $offre->lienOffre }}">{{ $offre->lienOffre }}</a>
                        @endif

                        <hr>
                        <p>Fichier téléchargeable :</p>
                        @if($offre->depot == null)
                            <p class="alert alert-warning">cette annonce n'a pas de fichier</p>
                        @else
                            <a href="{{ asset($offre->depot) }}" download>télécharger le fichier</a>
                        @endif

                    </div>
                </div>
            </div>


        </div>

    </div>
@endsection
