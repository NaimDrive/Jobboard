@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">{{$entreprise->nom}}</h1>
                    </div>
                <div class="card-body text-center">
                    <h4>Siret : {{$entreprise->siret}} </h4>
                    @php($i = 0)
                    @foreach($entreprise->adress as $adresse)
                        <h4> Adresse {{$i+1}}</h4>
                        <p> Rue : {{$adresse->nomRue}}</p>
                        <p> Ville : {{$adresse->ville}} </p>
                        <p> Code postale : {{$adresse->coordonnePostales}}</p>
                        @php($i++)
                    @endforeach
                    @php($j = 0)
                    @foreach($entreprise->contacts as $contact)
                        <h4> Contact {{$j+1}}</h4>
                        <p> Civilité : {{$contact->civilite}}</p>
                        <p>Nom : {{$contact->nom}}</p>
                        <p>Prenom : {{$contact->prenom}}</p>
                        <p>Mail : {{$contact->mail}}</p>
                        <p>Telephone : {{$contact->telephone}}</p>
                        @php($j++)
                    @endforeach
                </div>


@endsection