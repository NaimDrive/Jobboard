@extends('layouts.master')

@section('content')
    <div class="container">


        <h1 class="ml-2 ">{{$entreprise->nom}}</h1>
        @foreach(Auth::user()->roles as $role)
            @if(Auth::id() == $entreprise->getCreateur->user->id ||$role->typeRole == 'ADMIN')
                <a href="{{route("editEntreprise",["id"=>$entreprise->id])}}" class="btn btn-success float-right">Modifier</a>
            @endif
        @endforeach
        <p class="ml-3">SIRET : {{$entreprise->siret}}</p>

        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="card-header">Description</h2>
                    <div class="card-body">
                        <p class="ml-2 text-justify">
                            {!! $entreprise->description !!}
                        </p>
                    </div>

                </div>

                <div class="card mt-5">
                    @if($entreprise->offres->count() == 1)
                        <h2 class="card-header">Notre annonce</h2>
                    @elseif($entreprise->offres->count() == 0)
                        <div class="alert alert-warning">Nous n'avons pas encore posté d'annonce</div>
                    @else
                        <h2 class="card-header">Nos annonces</h2>
                    @endif
                    <div class="card-body">
                        @foreach($entreprise->offres as $offre)
                            <div class="border p-3 mt-3">
                                <h3><a href="{{ route('afficherUneOffre', ['id' => $offre->id]) }}">{{ $offre->nomOffre }}</a></h3>
                                <p><sub>Publiée le : {{ date('d/m/Y',strtotime($offre->datePublicationOffre)) }}</sub></p>
                                <h4>Description de l'offre</h4>

                                <p >Contexte : {{ $offre->description->contexte }}</p>
                                <p>Objectif : {{ $offre->description->objectif }}</p>
                                <p class="mt-1">Du {{ date('d/m/Y',strtotime($offre->dateDebut)) }} au {{ date('d/m/Y',strtotime($offre->dateFin)) }}</p>

                                <a class="btn btn-success" href="{{ route('afficherUneOffre', ['id' => $offre->id]) }}">Voir l'offre</a>
                            </div>


                        @endforeach
                    </div>

                </div>

            </div>

            <div class="col-md-4">
                <div class="card">
                    @if($entreprise->adress->count() == 1)
                        <h2 class="card-header">Notre adresse</h2>
                    @else
                        <h2 class="card-header">Nos adresses</h2>
                    @endif
                    <div class="card-body">
                        @foreach($entreprise->adress as $adresse)
                            <div class="border p-2 mt-2">
                                <p> {{ $adresse->nomRue }} </p>
                                <p> {{ $adresse->ville }} {{ $adresse->coordonnePostales }} </p>
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="card mt-5">
                    @if($entreprise->contacts->count() == 1)
                        <h2 class="card-header">Notre contact</h2>
                    @else
                        <h2 class="card-header">Nos contacts</h2>
                    @endif
                    <div class="card-body">
                        @foreach($entreprise->contacts as $contact)
                            <div class="border p-3 mt-2">
                                <a href={{ route("afficherUnContact",["id"=>$contact->id]) }}>{{ $contact->prenom }} {{$contact->nom}}</a>
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="card mt-5">
                    @if ($entreprise->forums != null)
                        <h2 class="card-header">Nous participons</h2>
                        <div class="card-body">
                            @foreach($entreprise->forums as $forum)
                                <div class="border p-3 mt-2">
                                    <a href="{{route("afficherUnForum",["id"=>$forum->id])}}">Le forum du {{date('d/m/Y',strtotime($forum->date))}}</a>
                                </div>
                            @endforeach
                        </div>    
                    @endif
                </div>


            </div>



        </div>
    </div>
@endsection
