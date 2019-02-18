@extends('layouts.master')

@section('content')
    <div class="container">

        <h1 class="ml-2 mt-4">{{$entreprise->nom}}</h1>
        <p class="ml-3">SIRET : {{$entreprise->siret}}</p>

        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="card-header">Déscription</h2>
                    <p class="ml-2 justify-content">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad distinctio praesentium repellat temporibus?
                        Adipisci asperiores at distinctio ea eius eligendi esse impedit, modi non, quod totam vel, voluptatem.
                        Inventore, nihil?
                    </p>
                </div>

                <div class="card mt-5">
                    @if($entreprise->offres->count() == 1)
                        <h2 class="card-header">Notre annonce</h2>
                    @elseif($entreprise->offres->count() == 0)
                        <div class="alert alert-danger">Nous n'avons pas encore posté d'annonce</div>
                    @else
                        <h2 class="card-header">Nos annonces</h2>
                    @endif
                    @foreach($entreprise->offres as $offre)
                        <div class="border p-3">
                            <h3>{{ $offre->nomOffre }}</h3>
                            <p>{{ $offre->datePublicationOffre }}</p>
                            <h4>Description de l'offre</h4>

                            <p >Contexte : {{ $offre->description->contexte }}</p>
                            <p>Objectif : {{ $offre->description->objectif }}</p>
                            <p class="mt-1">Du {{ $offre->dateDebut }} au {{ $offre->dateFin }}</p>
                        </div>


                    @endforeach
                </div>

            </div>

            <div class="col-md-4">
                <div class="card">
                    @if($entreprise->adress->count() == 1)
                        <h2 class="card-header">Notre adresse</h2>
                    @else
                        <h2 class="card-header">Nos adresses</h2>
                    @endif

                    @foreach($entreprise->adress as $adresse)
                        <div class="border p-2">
                            <p> {{ $adresse->nomRue }} </p>
                            <p> {{ $adresse->ville }} {{ $adresse->coordonnePostales }} </p>
                        </div>
                        @endforeach
                </div>


                <div class="card mt-5">
                    @if($entreprise->contacts->count() == 1)
                        <h2 class="card-header">Notre contact</h2>
                    @else
                        <h2 class="card-header">Nos contacts</h2>
                    @endif

                    @foreach($entreprise->contacts as $contact)
                        <div class="border p-3">
                            <a href="">{{ $contact->prenom }} {{$contact->nom}}</a>
                        </div>
                    @endforeach
                </div>


            </div>



        </div>
    </div>
@endsection