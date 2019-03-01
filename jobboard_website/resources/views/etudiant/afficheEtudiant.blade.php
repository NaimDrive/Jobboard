@extends('layouts.master')

@section('content')

<?php
        $idEtu = DB::table('etudiant')->get();
?>
    <legend> Liste des Etudiants</legend>

    @foreach($idEtu as $etu)
    <?php

    $nom =DB::table('users')->where('id',$etu->idUser)->value('nom');
    $prenom =DB::table('users')->where('id',$etu->idUser)->value('prenom');
    $age = DB::table('etudiant')->where('id',$etu->id)->value('DateDeNaissance');
    $formation = DB::table('etudiant')->where('id',$etu->id)->value('etudes');
    $rechercheStage =DB::table('etudiant')->where('id',$etu->id)->value('rechercheStage');
    //boutton consult profil
    ?>
    <form>
    <div class="border p-3 mt-3">
    {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
        
            <td> {{$nom}}</td>
            <td> {{$prenom}}</td>
            <td> {{$age}}</td>
            <td> {{$formation}}</td>
            @if($rechercheStage==1)
            <td> A la recherche un stage</td>
            @endif
            <br>
            <td>  <a class="btn btn-success" href="{{ route('consult_profile',["id"=>$etu->id]) }}" >Voir le profil Etudiant </a></td>
            </div>
        </form>

        @endforeach
@endsection