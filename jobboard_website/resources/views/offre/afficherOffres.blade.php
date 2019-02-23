@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="card mt-4">
            <h1 class="card-header">Les offres</h1>
            <div class="card-body">
                @foreach($offres as $offre)
                    <div class="border p-3 mt-2">
                        <h3>{{ $offre->nomOffre }}</h3>
                        <p>{{ $offre->natureOffre }}</p>
                        <p>Date du stage : du <strong>{{ $offre->dateDebut }}</strong> au <strong>{{ $offre->dateFin }}</strong></p>
                        <p>Pré-embauche possible : {{ $offre->preembauche }}</p>
                        <a href="{{route("afficherUneOffre",["id"=>$offre->id])}}" class="btn btn-success">Voir l'offre</a>

                    </div>
                @endforeach
            </div>
        </div>



    </div>

@endsection
