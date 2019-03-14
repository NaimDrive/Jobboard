@extends('layouts.master')

@section('content')
<div class="container">
    <div class="card mt-4">
        <h1 class="card-header">Mes offres</h1>
        <div class="card-body">
    @foreach($offres as $offre)
    <div class="border p-3 mt-2">
                    <h3>{{ $offre->nomOffre }}</h3>
                    <p class="ml-1"><sub>Publiée le : {{ date('d/m/Y',strtotime($offre->datePublicationOffre)) }}</sub></p>
                    <p>{{ $offre->natureOffre }}</p>
                    <p>Date du stage : du <strong>{{ date('d/m/Y',strtotime($offre->dateDebut)) }}</strong> au <strong>{{ date('d/m/Y',strtotime($offre->dateFin)) }}</strong></p>
                    <div class="row ml-2">
                        <a href="{{route("afficherUneOffre",["id"=>$offre->id])}}" class="btn btn-success">Voir l'offre</a>
                        @if(Auth::check() && Auth::user()->isEtudiant())
                            @if($etudiant->isSaved($offre->id))
                                <div class="ml-5">
                                    <a href="{{route('dropOffreEtu',["id"=>$offre->id])}}" class="btn btn-success">Ne plus sauvegarder l'offre</a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mt-3">{{ $offres->links() }}</div>
</div>


@endsection
