@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Administration </h1>
            </div>
        </div>

        <div class="row" id="linge_admin">
            <div class="col-12 col-md-12" id="ligne_admin">
                <h3>Etudiants</h3>
                <button class="btn-primary text-center" id="btn_etu">Visionner</button>
                <button class="btn-success text-center" id="btn_etu">Ajouter</button>
                <button class="btn-danger text-center" id="btn_etu">Supprimer</button>
            </div>
        </div>
        <div class="row" id="ligne_admin">
            <div class="col-12 col-md-12" id="ligne_admin">
                <h3>Entreprise</h3>
                <button class="btn-primary text-center" id="btn_ent">Visionner</button>
                <a href="{{route('creerEntreprise')}}"><button class="btn-success text-center" id="btn_ent">Ajouter</button></a>
                <button class="btn-danger text-center" id="btn_ent">Supprimer</button>
            </div>
        </div>
        <div class="row" id="ligne_admin">
            <div class="col-12 col-md-12" id="ligne_admin">
                <h3>Contact</h3>
                <button class="btn-primary text-center" id="btn_ct">Visionner</button>
                <button class="btn-success text-center" id="btn_ct">Ajouter</button>
                <button class="btn-danger text-center" id="btn_ct">Supprimer</button>
            </div>
        </div>
        <div class="row" id="ligne_admin">
            <div class="col-12 col-md-12" id="ligne_admin">
                <h3>Offres</h3>
                <button class="btn-primary text-center" id="btn_offre">Visionner</button>
                <button class="btn-success text-center" id="btn_offre">Ajouter</button>
                <button class="btn-danger text-center" id="btn_offre">Supprimer</button>
            </div>
        </div>
    </div>

@endsection


