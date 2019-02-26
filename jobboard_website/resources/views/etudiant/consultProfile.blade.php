@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-6">

                <div class="headerProfil">
                    <h1>Profil de {{$prenom}} {{$nom}}</h1> <br/>
                    <img src="{{asset($image)}}" title="photo de profil" width="150" height="150"/>
                </div>

                <br/>
                <div class="info">
                    <div class="gauche">
                        <div class="card border-primary mb-3" style="max-width: 20rem;">
                            <div class="card-header"><h5>IDENTITE</h5></div>
                            <div class="card-body">
                                <p class="card-text"> Civilité : {{$etudiant->civilite}} <br/>
                                    Nom : {{$nom}} <br/>
                                    Prenom : {{$prenom}} <br/>
                                    Né(e) le {{$etudiant->DateDeNaissance}} <br/> </p>
                            </div>
                        </div>
                    </div>
                    <div class="droite">
                        <div class="card border-primary mb-3" style="max-width: 20rem;">
                            <div class="card-header"><h5>COORDONNEES</h5></div>
                            <div class="card-body">
                                <p class="card-text"> Adresse : {{$etudiant->adresse}} <br/>
                                    Code postal : {{$etudiant->codePostal}} <br/>
                                    Ville : {{$etudiant->ville}} <br/> </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class ="lien">
                    <div class="card mt-5">
                        @if(count($liens) == 1)
                            <h2 class="card-header">LIEN </h2>
                        @elseif($liens->count() == 0)
                            <div class="alert alert-warning">PAS DE LIEN DISPONIBLE</div>
                        @else
                            <h2 class="card-header"> LIENS </h2>
                        @endif
                        <div class="card-body">
                            @foreach($liens as $li)
                                <div class="border p-3 mt-3">
                                    <h3>{{ $li->nomReference }}</h3>
                                    <p>{{ $li->UrlReference }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <table class="table table-hover">

                    <thead>
                    <tr>
                        <th scope="col"> COMPETENCES </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="table-active">

                        @foreach($categorie as $cat)
                            <th scope="row">{{$cat}}</th>
                        @endforeach

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

    <!-- Styles -->
    <style>
        .headerProfil{
            text-align: center;
            margin-right: auto;
            margin-left: auto;
            display: block;
        }
        .card-header{
            text-align: center;
        }

        .info{
            width: 100%;
            display: inline-block;
        }
        .droite{
            float: right;
            width: 45%;
        }
        .gauche{
            float: left;
            width: 45%;
        }
    </style>





