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

        @foreach($entreprises as $entreprise)
         <div class="row" id="btnEntrepriseAdmin">
             <div class="col-3 col-md-3">
                 <p>{{$entreprise->nom}}</p>
             </div>

             <div class="col-3 col-md-3">
                 <a href = '{{route('afficherUneEntreprise',[$entreprise->id])}}'><button class="btn-primary">Visionner</button></a>
             </div>
             <div class="col-3 col-md-3">
                 <a href="{{route("editEntreprise",["id"=>$entreprise->id])}}">"<button class="btn-secondary">Modifier</button></a>
             </div>

             <div class="col-3 col-md-3">
                 <a href = '{{route('supprimerUneEntreprise',[$entreprise->id])}}'><button class="btn-danger">Supprimer</button></a>
             </div>


        </div>
        @endforeach
    </div>




@endsection

