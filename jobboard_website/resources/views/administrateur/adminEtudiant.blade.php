@extends('layouts.master')

@section('content')


    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Etudiants</h1>
            </div>
        </div>


        <div class="row" id="btnEntrepriseAdmin">
        @foreach($etudiants as $etu)
                <div class="card text-center col-12 col-md-3">
                    <div class="card-body">
                        <strong><p class="card-title text-center"> {{$etu->user->nom}}  {{$etu->user->prenom}}</p></strong>
                        <a href="{{route('consult_profile',[$etu->id])}}"><button class="btn-primary mb-2">Visionner</button></a><br>
                        <a href="{{route('edit_profile',[$etu->id])}}"> <button class="btn-secondary mb-2">Modifier</button></a><br>
                        <a href="{{route('supprimerUnEtudiant',[$etu->id])}}"><button class="btn-danger mb-2">Supprimer</button></a><br>
                    </div>
                </div>
        @endforeach
        </div>
    </div>






@endsection