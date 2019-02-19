@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Etudiants</h1>
            </div>
        </div>



        @foreach($etudiants as $etu)
            <div class="row" id="btnEntrepriseAdmin">
                <div class="col-3 col-md-3">
                    <strong><p> {{$etu->user->nom}}  {{$etu->user->prenom}}</p></strong>
                </div>
                <div class="col-3 col-md-3">
                    <a href="{{route('consult_profile',[$etu->id])}}"><button class="btn-primary">Visionner</button></a>
                </div>
                <div class="col-3 col-md-3">
                    <a href="{{route('edit_profile',[$etu->id])}}"> <button class="btn-secondary">Modifier</button></a>
                </div>

                <div class="col-3 col-md-3">
                    <a href="{{route('supprimerUnEtudiant',[$etu->id])}}"><button class="btn-danger">Supprimer</button></a>
                </div>
            </div>
        @endforeach
    </div>





@endsection