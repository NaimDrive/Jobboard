@extends('layouts.master')

@section('content')
    <?php
        $idOffre = DB::table('offre')->pluck('id');


    ?>
    <legend> Liste des offres</legend>
    @foreach($idOffre as $idO)
        <?php
        $nom =DB::table('offre')->where('id',$idO)->value('nomOffre');
        $nature =DB::table('offre')->where('id',$idO)->value('natureOffre');
        $dateD= DB::table('offre')->where('id',$idO)->value('dateDebut');
        $dateF = DB::table('offre')->where('id',$idO)->value('dateFin');
        $preembauche= DB::table('offre')->where('id',$idO)->value('preembauche') ;
        $idEntreprise = DB::table('offre')->where('id',$idO)->value('idEntreprise');
        $nomEntreprise = DB::table('entreprise')->where('id',$idEntreprise)->value('nom');
        ?>
        <form>
        {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
            <th>  {{$nom }}</th>
            <td> {{$nomEntreprise}}</td>
            <td> {{$nature}}</td>
            <td> {{$dateD}}</td>
            <td> {{$dateF}}</td>
            <td> {{$preembauche}}</td>
            <td>  <a rel="nofollow" href="" target="_parent">Voir l'offre</a></td>
        </form>

    @endforeach
@endsection
