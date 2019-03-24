@extends('layouts.master')

@section('content')
        
    <div class="container">
        <div class="card">
            <h1 class="card-header">Nos Etudiants</h1>
            <div class="card-body">
                <div class="row">
                    <a href="{{route('toutlesEtudiants', ['recherche'=>1, 'etudes'=>$etudes])}}" class="btn btn-success ml-5 col-2">Voir les étudiants en recherche</a>
                    <a href="{{route('toutlesEtudiants', ['recherche'=>$recherche, 'etudes'=>1])}}" class="btn btn-success offset-1 col-2">Voir les étudiants de DUT</a>
                    <a href="{{route('toutlesEtudiants', ['recherche'=>$recherche, 'etudes'=>2])}}" class="btn btn-success offset-1 col-2">Voir les étudiants de LP</a>
                    <a href="{{route('toutlesEtudiants', ['recherche'=>0, 'etudes'=>0])}}" class="btn btn-success offset-1 col-2">Voir tous les étudiants</a>
                </div>
            @foreach($etudiants as $etu)
                @if($etu->idUser != null)
                        <div id="startIf"></div>
                        <div class="border p-3 mt-2">
                            <p>{{ $etu->civilite }} <strong>{{$etu->user->nom}} {{$etu->user->prenom}}</strong></p>
                            <p>Né le : <strong>{{ date('d/m/Y',strtotime($etu->DateDeNaissance)) }}</strong></p>
                            <p>Etudes : <strong>{{$etu->etudes}}</strong></p>
                            @if($etu->rechercheStage==1)
                            <p> A la recherche d'un stage</p>
                            @endif
                            <a href="{{ route('consult_profile',["id"=>$etu->id])}}" class="btn btn-success">Voir le Profil</a>
                        </div>
                        <div id="endIf"></div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="mt-3">{{ $etudiants->links() }}</div>
    </div>

@endsection