@extends('layouts.master')

@section('content')


    <div class="container">
        <div class="card mt-4">
            <h1 class="card-header">Les Recherches de nos étudiants </h1>
            <div class="card-body">
                @foreach($etudiants as $etu)
                        <div class="border p-3 mt-2">
                            <p> {{ $etu->civilite }} <b>{{$etu->user->nom}} {{$etu->user->prenom}}</b></p>
                            @foreach($etu->recherches as $r)
                                <div class="border p-3 mt-2">
                                      <p>Souhait: {{$r->souhait}}</p>
                                      <p>Date de début de stage: {{$r->dateD}} </p>
                                      <p>Date minimum de fin de stage: {{$r->dateF}} </p>
                                      <p>Mobilité: {{$r->mobi}}</p>
                                        <div class="row ml-2">
                                             <a class="btn btn-success" href="{{ route('consult_profile',["id"=>$etu->id]) }} "> Voir le profile</a>
                                         </div>
                                </div>
                            @endforeach
                             </div>
                    @endforeach
            </div>
            <div class="mt-3">{{ $etudiants->links() }}</div>

        </div>
    </div>

@endsection