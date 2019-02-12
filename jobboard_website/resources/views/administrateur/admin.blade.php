@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Tableau de bord </h1>
            </div>
        </div>

        <div class="row" id="linge_admin">
            <div class="col-12 col-md-3" id="ligne_admin">
                <h3>Etudiants</h3>
                <p> affichage de 10 étudiants</p>
                <button class="btn-primary"><a href="#"></a>Voir + </button>
            </div>

            <div class="col-12 col-md-3" id="ligne_admin">
                <h3>Entreprise</h3>
                    @foreach($entreprises as $entreprise)
                        @if($entreprise->id <=10)
                        <p>{{ $entreprise->nom }}</p>
                        @endif
                    @endforeach
                <a href="{{route('administrerUneEntreprise')}}"><button class="btn-primary">Voir + </button></a>
            </div>

            <div class="col-12 col-md-3" id="ligne_admin">
                <h3>Contact</h3>
                <p> affichage de 10 contacts</p>
                <button class="btn-primary">Voir + </button>
            </div>

            <div class="col-12 col-md-3" id="ligne_admin">
                <h3>Offres</h3>
                <p> affichage de 10 offres</p>
                <button class="btn-primary"><a href="#"></a>Voir + </button>
            </div>
        </div>
    </div>

@endsection


