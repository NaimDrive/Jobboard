@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1> Administration </h1>
            </div>
        </div>

        <div class="row">
        <div class="col-6 col-md-6" style="margin-top: 50px;">
                <h3> Etudiant</h3>
                <button class="btn-primary text-center" id="btn_etu">Visionner</button>
                <button class="btn-success text-center" id="btn_etu">Ajouter</button>
                <button class="btn-danger text-center" id="btn_etu">Supprimer</button>
        </div>
        <div class="col-6 col-md-6" style="margin-top: 50px;">
            <h3> Entreprise</h3>
            <button class="btn-primary text-center" id="btn_etu">Visionner</button>
            <button class="btn-success text-center" id="btn_etu">Ajouter</button>
            <button class="btn-danger text-center" id="btn_etu">Supprimer</button>
        </div>
        </div>
    </div>
    </div>

@endsection


