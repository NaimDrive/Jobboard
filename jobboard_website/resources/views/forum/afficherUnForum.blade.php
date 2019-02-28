@extends("layouts.master")
@section("content")
    <div class="container">
        <div class="card mt-4">
            <h2 class="card-header">Forum du {{$forum->date}}</h2>
            <div class="card-body">
                <p>Le forum débutera à {{$forum->heure}}</p>
                <p><strong>Entreprises présentes</strong></p>
                @foreach($forum->entreprises as $entreprise)
                    <div class="border p-3 mt-3">
                        <a href="{{route('afficherUneEntreprise',["id"=>$entreprise->entrepriseP->id])}}"><strong>{{$entreprise->entrepriseP->nom}}</strong></a>

                        <p><strong>Contacts présents : </strong></p>
                        <ul>
                            @foreach($entreprise->contacts as $contact)
                                <li><a href="{{route('afficherUnContact',["id"=>$contact->contact->id])}}">{{ $contact->contact->prenom }} {{ $contact->contact->nom }}</a>, {{$contact->contact->role}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection