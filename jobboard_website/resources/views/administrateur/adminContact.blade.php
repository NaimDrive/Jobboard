@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Contacts</h1>
            </div>
        </div>

        @foreach($contacts as $contact)
            <div class="row" id="btnEntrepriseAdmin">
                <div class="col-3 col-md-3">
                    <p>{{$contact->nom}} {{$contact->prenom}}</p>
                </div>

                <div class="col-3 col-md-3">
                    <a href="{{route('afficherUnContact',[$contact->id])}}"><button class="btn-primary">Visionner</button></a>
                </div>
                <div class="col-3 col-md-3">
                    <a href="{{route('editContact',[$contact->id])}}"><button class="btn-secondary">Modifier</button></a>
                </div>

                <div class="col-3 col-md-3">
                    <a href = '{{route('supprimerUnContact',[$contact->id])}}'><button class="btn-danger">Supprimer</button></a>
                </div>


            </div>
        @endforeach
    </div>
@endsection