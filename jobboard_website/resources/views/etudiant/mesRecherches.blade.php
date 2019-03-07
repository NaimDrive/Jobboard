@extends('layouts.master')

@section('content')
<div class="container">
    <div class="card mt-4">
        <h1 class="card-header">Mes offres</h1>
        <div class="card-body">
    @foreach($idRecherche as $idR)
        <div class="border p-3 mt-2">
        <?php
        $nomOffre = DB::table('offre')->where('id',$idR->idOffre)->value('nomOffre');
        $idEntreprise = DB::table('offre')->where('id',$idR->idOffre)->value('idEntreprise');
        $nomEntreprise = DB::table('entreprise')->where('id',$idEntreprise)->value('nom');
        ?>
        <p> Nom de l'offre : {{$nomOffre}}</p>
        <p>Nom de l'entreprise: {{$nomEntreprise}}</p>
            <div class="row ml-2">
                <a href="{{route("afficherUneOffre",["id"=>$idR->id])}}" class="btn btn-success">Voir l'offre</a>
            <div class="ml-5">
                <a href="{{route('dropOffre',["id"=>$idR->id])}}" class="btn btn-success">Ne plus sauvegarder l'offre</a>
            </div>
        </div>
        </div>
    @endforeach
        </div>
    </div>
</div>


@endsection