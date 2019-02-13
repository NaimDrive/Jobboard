@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Etudiants</h1>
                <a href="{{route('creer_etudiant')}}"> <button class="btn-success" id="btnEntrepriseAdmin">Ajouter un etudiant</button></a>
            </div>
        </div>



        @foreach($etudiants as $etu)
            <div class="row" id="btnEntrepriseAdmin">
                <div class="col-4 col-md-4">
                    <strong><p> {{$etu->user->nom}}  {{$etu->user->prenom}}</p></strong>
                </div>

                <div class="col-4 col-md-4">
                    <button class="btn-secondary">Modifier</button>
                </div>

                <div class="col-4 col-md-4">
                    <button class="btn-danger">Supprimer</button>
                </div>
            </div>
        @endforeach
    </div>





@endsection