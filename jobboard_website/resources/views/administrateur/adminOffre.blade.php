@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Offre</h1>
                <a href="#"> <button class="btn-success" id="btnEntrepriseAdmin">Ajouter une offre</button></a>
            </div>
        </div>


        @foreach($offres as $offre)
            <div class="row" id="btnEntrepriseAdmin">
                <div class="col-4 col-md-4">
                    <strong><p> {{$offre->nomOffre}}  {{$offre->nature}}</p></strong>
                </div>

                <div class="col-4 col-md-4">
                    <button class="btn-secondary">Modifier</button>
                </div>

                <div class="col-4 col-md-4">
                    <a href="{{route('supprimerUneOffre',[$offre->id])}}"><button class="btn-danger">Supprimer</button></a>
                </div>
            </div>
        @endforeach
    </div>
@endsection