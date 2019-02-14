@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Contacts</h1>
                <button class="btn-success" id="btnEntrepriseAdmin">Ajouter un contact</button>
            </div>
        </div>

        @foreach($contacts as $contact)
            <div class="row" id="btnEntrepriseAdmin">
                <div class="col-4 col-md-4">
                    <p>{{$contact->nom}} {{$contact->prenom}}</p>
                </div>

                <div class="col-4 col-md-4">
                    <button class="btn-secondary">Modifier</button>
                </div>

                <div class="col-4 col-md-4">
                    <a href = '{{route('supprimerUnContact',[$contact->id])}}'><button class="btn-danger">Supprimer</button></a>
                </div>


            </div>
        @endforeach
    </div>
@endsection