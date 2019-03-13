@extends('layouts.master')

@section('content')
<div class="container">
        <div class="card mt-4">
            <h1 class="card-header">Mes offres</h1>
            <div class="card-body">
        @foreach($etudiant->offresSaved as $OffreSave)
        <div class="border p-3 mt-2">
                        <h3>{{ $OffreSave->nomOffre }}</h3>
                        <p class="ml-1"><sub>Publiée le : {{ date('d/m/Y',strtotime($OffreSave->datePublicationOffre)) }}</sub></p>
                        <p>{{ $OffreSave->natureOffre }}</p>
                        <p>Date du stage : du <strong>{{ date('d/m/Y',strtotime($OffreSave->dateDebut)) }}</strong> au <strong>{{ date('d/m/Y',strtotime($OffreSave->dateFin)) }}</strong></p>
                        <div class="row ml-2">
                            <a href="{{route("afficherUneOffre",["id"=>$OffreSave->id])}}" class="btn btn-success">Voir l'offre</a>
                            @if(Auth::check() && Auth::user()->isEtudiant())
                                @php($idEtudiant = DB::table('etudiant')->where('idUser',Auth::id())->value('id'))
                                @php($etudiant = \App\Etudiant::find($idEtudiant))
                                @if($etudiant->isSaved($OffreSave->id))
                                    <div class="ml-5">
                                        <a href="{{route('dropOffreEtu',["id"=>$OffreSave->id])}}" class="btn btn-success">Ne plus sauvegarder l'offre</a>
                                    </div>
                                @endif
                            @endif

                        </div>


                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection