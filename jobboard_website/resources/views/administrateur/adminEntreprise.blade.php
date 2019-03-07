@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Entreprises</h1>
                <a href="{{route('creerEntreprise')}}"> <button class="btn-success" id="btnEntrepriseAdmin">Ajouter une entreprise</button></a>
            </div>
        </div>

        <div class="row mt-3" id="btnEntrepriseAdmin">
            @foreach($entreprises as $entreprise)
                <div class="card text-center col-12 col-md-3">
                    <div class="card-body">
                        <strong><p class="card-title text-center"> {{$entreprise->nom}}</p></strong>
                        <a href="{{route('afficherUneEntreprise',[$entreprise->id])}}"><button class="btn-primary mb-2">Visionner</button></a><br>
                        <a href="{{route('editEntreprise',[$entreprise->id])}}"> <button class="btn-secondary mb-2">Modifier</button></a><br>
                        <a href="{{route('supprimerUneEntreprise',[$entreprise->id])}}"><button class="btn-danger mb-2">Supprimer</button></a><br>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3">{{ $entreprises->links() }}</div>
    </div>




@endsection

