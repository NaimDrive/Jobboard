@extends('layouts.master')

@section('content')


    <div class="container">
        <div class="card mt-4">
            <h1 class="card-header">Les Recherches de nos étudiants </h1>
            <div class="card-body">
                @foreach($recherches as $r)

                        <div class="border p-3 mt-2">
                            <p> {{ $r->etudiant->civilite }} <b>{{$r->etudiant->user->nom}} {{$r->etudiant->user->prenom}}</b></p>
                                <div class="border p-3 mt-2">
                                      <p>Souhait: {{$r->souhait}}</p>
                                      <p>Date de début de stage: {{$r->dateDebut}} </p>
                                      <p>Date minimum de fin de stage: {{$r->dateFin}} </p>
                                      <p>Mobilité: {{$r->mobilite}}</p>
                                        <div class="row ml-2">
                                             <a class="btn btn-success" href="{{ route('consult_profile',["id"=>$r->etudiant->id]) }} "> Voir le profile</a>
                                         </div>
                                </div>
                             </div>
                        @endforeach
            </div>
            <div class="mt-3">{{ $recherches->links() }}</div>

        </div>
    </div>

@endsection