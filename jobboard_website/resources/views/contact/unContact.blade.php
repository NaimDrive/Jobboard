@extends('layouts.master')

@section('content')

    <div class="container">

        <div class="row">
            @if($contact->user->picture != null)
                <img class="avatar" src="{{ asset($contact->user->picture) }}">
            @endif
            <h1 class="ml-5">{{ $contact->prenom }} {{$contact->nom}}</h1>
        </div>

        
        @foreach(Auth::user()->roles as $role)
            @if(Auth::id() == $contact->idUser || $role->typeRole == 'ADMIN')
                <a href="{{route("editContact",["id"=>$contact->id])}}" class="btn btn-success float-right">Modifier</a>
            @endif
        @endforeach
        <div class="row mt-5">


            <div class="col">
                <div class="card">
                    <h2 class="card-header">Mon entreprise</h2>
                    <div class="card-body">
                        @if($contact->idEntreprise != null)
                            <strong class="ml-2">Nom de l'entreprise</strong> : <a href="{{ route("afficherUneEntreprise",["id"=>$contact->entreprise->id]) }}" >{{$contact->entreprise->nom}}</a>
                            <p class="ml-2 mt-2"><strong>Role dans l'entreprise</strong> : {{ $contact->role }}</p>
                        @else
                            <div class="alert alert-warning">Je n'ai pas encore d'entreprise</div>
                        @endif
                    </div>

                </div>
            </div>

            <div class="col">
                <div class="card">
                    <h2 class="card-header">Me contacter</h2>
                    <div class="card-body">
                        <p>Contactez-moi via : {{$contact->mail}}</p>
                        @if($contact->telephone)
                            <p>Ou par téléphone au {{$contact->telephone}}</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>


@endsection
