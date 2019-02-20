@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="card">
            <h1 class="card-header">Les contacts</h1>
            <div class="card-body">
                @foreach($contacts as $contact)
                    @if($contact->idUser != null)
                    <div class="border p-3 mt-2">
                        <p>{{$contact->civilite}} {{$contact->prenom}} {{$contact->nom}}</p>
                        <p>E-mail : {{$contact->mail}}</p>
                        <a href="{{route("afficherUnContact",["id"=>$contact->id])}}" class="btn btn-success">Voir le contact</a>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

@endsection