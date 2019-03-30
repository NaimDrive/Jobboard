@extends('layouts.master')

@section('content')


    <div class="container">
        <div class="card mt-4">
            <h1 class="card-header">Les recherches de nos étudiants </h1>
            <div class="card-body">
            @foreach($recherches as $r)
                <?php 
                $date1 = strtotime($r->dateDebut);
                $date2 = strtotime ($r->dateFin);
                $res = round(round(abs( $date2 - $date1  )/60/60/24)/7);
                ?>
                <div class="border p-3 mt-2">
                    <p> {{ $r->etudiant->civilite }} <b>{{$r->etudiant->user->nom}} {{$r->etudiant->user->prenom}}</b></p>
                        <div class="border p-3 mt-2">
                            <p>Souhait: {{$r->souhait}}</p>
                            <p>Date de début de stage: {{ date('d/m/Y',strtotime($r->dateDebut)) }}</p>
                            <p>Date minimum de fin de stage: {{ date('d/m/Y',strtotime($r->dateFin)) }} </p>
                            <p>Durée: {{$res}} semaines </p>
                            <p>Secteur Géographique : {{$r->secteurGeo}}</p>
                            <p>Mobilité: {{$r->mobilite}}</p>
                                <div class="row ml-2">
                                    <a class="btn btn-success" href="{{ route('consult_profile',["id"=>$r->etudiant->id]) }} "> Voir le profil</a>
                                </div>
                        </div>
                </div>
            @endforeach
            </div>
            <div class="mt-3">{{ $recherches->links() }}</div>

        </div>
    </div>

@endsection