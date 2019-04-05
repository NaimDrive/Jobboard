@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Contacts</h1>
            </div>
        </div>

        <div class="row" id="btnEntrepriseAdmin">
            @foreach($contacts as $contact)
                @php($image = $contact->user->picture)
                <div class="card text-center col-12 col-md-3">
                    <div class="card-body">
                        <strong><p class="card-title text-center"> {{$contact->nom}}  {{$contact->prenom}}</p></strong>
                        @if($image != null)
                            <p class="text-center"><img src="{{asset($image)}}" alt="photo de profil" width="50" height="50"/></p>
                        @endif
                        <a href="{{route('afficherUnContact',[$contact->id])}}"><button class="btn-primary mb-2">Visionner</button></a><br>
                        <a href="{{route('editContact',[$contact->id])}}"> <button class="btn-secondary mb-2">Modifier</button></a><br>
                        <a href="{{route('supprimerUnContact',[$contact->id])}}"><button class="btn-danger mb-2">Supprimer</button></a><br>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-3">{{ $contacts->links() }}</div>
    </div>
@endsection