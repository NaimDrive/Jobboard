@extends('layouts.master')

@section('content')


    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Etudiants</h1>
            </div>
        </div>


        <div class="row" id="btnEntrepriseAdmin">
        @foreach($etudiants as $etu)
            @php($image = $etu->user->picture)

            <div class="card text-center col-12 col-md-3">
                <div class="card-body">
                    <strong><p class="card-title text-center"> {{$etu->user->nom}}  {{$etu->user->prenom}}</p></strong>
                    @if($image != null)
                    <p class="text-center"><img src="{{asset($image)}}" alt="photo de profil" width="50" height="50"/></p>
                    @endif
                    <a href="{{route('consult_profile',[$etu->id])}}"><button class="btn-primary mb-2">Visionner</button></a><br>
                    <a href="{{route('edit_profile',[$etu->id])}}"> <button class="btn-secondary mb-2">Modifier</button></a><br>
                    <a href="{{route('supprimerUnEtudiant',[$etu->id])}}"><button class="btn-danger mb-2">Supprimer</button></a><br>
                </div>
            </div>

        @endforeach
        </div>
        <div class="mt-3">{{ $etudiants->links() }}</div>
    </div>






@endsection
