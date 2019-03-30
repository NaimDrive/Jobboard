@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="card">
            <h1 class="card-header">Les contacts</h1>
            <div class="card-body">
                @foreach($contacts as $contact)
                    <div class="border p-3 mt-2">
                        <p>{{$contact->civilite}} {{$contact->prenom}} {{$contact->nom}}</p>
                        @if($contact->idEntreprise != null)
                            <p><strong>Entreprise</strong> : {{ $contact->entreprise->nom }}</p>
                        @endif
                        <p><strong>Rôle dans l'entreprise</strong> : {{ $contact->role }}</p>
                        <a href="{{route("afficherUnContact",["id"=>$contact->id])}}" class="btn btn-success">Voir le contact</a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-3">{{ $contacts->links() }}</div>
    </div>

@endsection
