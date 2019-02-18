@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>{{ $contact->prenom }} {{$contact->nom}}</h1>





        <div class="row mt-5">


            <div class="card col">
                <h2 class="card-header">Mon entreprise</h2>
                    <a class="ml-2" href="{{ route("afficherUneEntreprise",["id"=>$contact->entreprise->id]) }}" >{{$contact->entreprise->nom}}</a>
            </div>

            <div class="card col">
                <h2 class="card-header">À propos de moi</h2>
                <div class="card-body">
                    <p>Contactez-moi via : {{$contact->mail}}</p>
                    <p>Ou par téléphone au {{$contact->telephone}}</p>
                </div>
            </div>
        </div>

    </div>


@endsection