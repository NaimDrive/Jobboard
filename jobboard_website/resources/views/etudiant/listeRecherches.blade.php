@extends('layouts.master')

@section('content')


    <div class="container">
        <div class="card mt-4">
            <h1 class="card-header">Les Recherches de nos étudiants </h1>
            <div class="card-body">
            <?php
                $recherche = DB::table('recherche')->pluck('id');
                ?>

                @foreach($recherche as $r)

                        <div class="border p-3 mt-2">
                            <?php

                                $idEtu = DB::table('recherche')->where('id',$r)->value('idEtudiant');
                                $idU = DB::table('etudiant')->where('id',$idEtu)->value('idUser');
                                $nom = DB::table('users')->where('id',$idU)->value('nom');
                                $prenom = DB::table('users')->where('id',$idU)->value('prenom');
                                $rechercheL = DB::table('recherche')->where('idEtudiant',$idEtu)->pluck('id');
                            ?>
                            <p><b>{{$nom}} {{$prenom}}</b></p>

                                 <?php
                                    $souhait =DB::table('recherche')->where('id',$r)->value('souhait');
                                    $dateD = DB::table('recherche')->where('id',$r)->value('DateDebut');
                                    $dateF = DB::table('recherche')->where('id',$r)->value('DateFin');
                                    $mobi = DB::table('recherche')->where('id',$r)->value('mobilite');
                                    ?>
                                <div class="border p-3 mt-2">
                                      <p>Souhait: {{$souhait}}</p>
                                      <p>Date de début de stage: {{$dateD}} </p>
                                      <p>Date minimum de fin de stage: {{$dateF}} </p>
                                      <p>Mobilité: {{$mobi}}</p>
                                        <div class="row ml-2">
                                             <a class="btn btn-success" href="{{ route('consult_profile',["id"=>$idEtu]) }} "> Voir le profile</a>
                                         </div>
                                </div>

                             </div>
                    @endforeach


            </div>
        </div>
    </div>

@endsection