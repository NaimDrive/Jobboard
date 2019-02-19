@extends('layouts.master')

@section('content')

    <div class="container">
        <img src="{{$contact->user->picture}}" alt="" class="roundedImage">
        <h1>{{ $contact->prenom }} {{$contact->nom}}</h1>
        @foreach(Auth::user()->roles as $role)
            @if(Auth::id() == $contact->idUser || $role->typeRole == 'ADMIN')
                <a href="{{route("editContact",["id"=>$contact->id])}}" class="btn btn-success float-right">Modifier</a>
            @endif
        @endforeach
        <div class="row mt-5">


            <div class="card col">
                <h2 class="card-header">Mon entreprise</h2>
                <div class="card-body">
                    @if($contact->idEntreprise != null)
                        <a class="ml-2" href="{{ route("afficherUneEntreprise",["id"=>$contact->entreprise->id]) }}" >{{$contact->entreprise->nom}}</a>
                    @else
                        <div class="alert alert-warning">Je n'ai pas encore d'entreprise</div>
                    @endif
                </div>

            </div>

            <div class="card col">
                <h2 class="card-header">Me contacter</h2>
                <div class="card-body">
                    <p>Contactez-moi via : {{$contact->mail}}</p>
                    <p>Ou par téléphone au {{$contact->telephone}}</p>
                </div>
            </div>
        </div>

    </div>


@endsection