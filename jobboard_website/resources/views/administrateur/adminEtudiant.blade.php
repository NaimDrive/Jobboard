@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Etudiants</h1>
                <a href="{{route('creer_etudiant')}}"> <button class="btn-success" id="btnEntrepriseAdmin">Ajouter un etudiant</button></a>
            </div>
        </div>



        @foreach($users as $user)
            <div class="row" id="btnEntrepriseAdmin">
                <div class="col-4 col-md-4">
                    @for($i = 0; $i<sizeof($etudiants_id); $i++)
                        @if($etudiants_id[$i] == $user->id)
                            <p> {{$user->nom}}  {{$user->prenom}}</p>
                </div>

                <div class="col-4 col-md-4">
                    <button class="btn-secondary">Modifier</button>
                </div>

                <div class="col-4 col-md-4">
                    <button class="btn-danger">Supprimer</button>
                </div>
                @endif
                @endfor
            </div>
        @endforeach
    </div>





@endsection