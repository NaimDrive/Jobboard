@extends('layouts.master')

@section('content')
    <link href="{{ asset('css/consultProfile.css') }}" rel="stylesheet">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-8">

                <!-- ENTETE PROFIL -->
                <div class="headerProfil">
                    <h1>Profil de {{$user->prenom}} {{$user->nom}}</h1> <br/>
                    <img src="{{asset($user->picture)}}" title="photo de profil" width="150" height="150"/>
                </div>

                <!-- INFORMATIONS PERSONNELLES -->
                <br/>
                <div class="info">
                    <div class="gauche">
                        <div class="card border-primary mb-3" style="max-width: 20rem;">
                            <div class="card-header"><h5>IDENTITE</h5></div>
                            <div class="card-body">
                                <p class="card-text"> Civilité : {{$etudiant->civilite}} <br/>
                                    Nom : {{$user->nom}} <br/>
                                    Prenom : {{$user->prenom}} <br/>

                                    Né{{($etudiant->civilite == "Madame") ? "e" : ""}} le {{ date('d/m/Y',strtotime($etudiant->DateDeNaissance)) }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="droite">
                        <div class="card border-primary mb-3" style="max-width: 20rem;">
                            <div class="card-header"><h5>COORDONNEES</h5></div>
                            <div class="card-body">
                                <p class="card-text"> Adresse : {{$etudiant->adresse}} <br/>
                                    Code postal : {{$etudiant->codePostal}} <br/>
                                    Ville : {{$etudiant->ville}}  </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- LES DIFFERENTS LIENS -->
                <div class ="lien">
                    <div class="card mt-5">
                        @if(count($liens) == 1)
                            <h5 class="card-header">LIEN </h5>
                        @elseif(count($liens) == 0)
                            <div class="alert alert-warning">PAS DE LIEN DISPONIBLE</div>
                        @else
                            <h5 class="card-header"> LIENS </h5>
                        @endif
                        <div class="card-body">
                            @foreach($liens as $lien)
                                <div class="border p-3 mt-3">
                                    <h5>{{ $lien->nomReference }}</h5>
                                    <p><a href="{{ $lien->UrlReference }}">{{ $lien->UrlReference }}</a></p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <br>

                <!-- POSTES RECHERCHÉS  -->

                @if(count($recherches)==0)
                    <h5> Recherce de poste </h5>
                    <p> aucune recherche de poste </p>
                @elseif(count($recherches)==1)
                    <h5> Je recherche actuellement ce poste :  </h5> <br>
                    <div class="alert alert-dismissible alert-secondary">
                        <strong> {{$recherches->souhait}}</strong> du {{date('d/m/y',strtotime($recherches->deteDebut))}} au {{date('d/m/y',strtotime($recherches->dateFin))}} <br>
                        mobilité : {{$recherches->mobilite}}
                    </div>
                @else
                    <h5> Je recherche actuellement ces postes :  </h5> <br>
                    @foreach($recherches as $recherche)
                        <div class="alert alert-dismissible alert-secondary">
                            <strong> {{$recherche->souhait}}</strong> du {{date('d/m/y',strtotime($recherche->dateDebut))}} au {{date('d/m/y',strtotime($recherche->dateFin))}} <br>
                            mobilité : {{$recherche->mobilite}}
                        </div>
                    @endforeach
                @endif
                <br>


                <!-- FORMATION  -->
                <h5> Ma formation </h5>
                @if(count($formations)==0)
                    <p> Pas de formation communiquée  </p>
                @else
                    @foreach($formations as $formation)
                        <div class="alert alert-dismissible alert-info">
                            <strong> {{$formation->natureFormation}} </strong> <br>
                            <p> lieu : {{$formation->lieuFormation}} <br>
                                période : du {{date('d/m/y',strtotime($formation->debut))}} au {{date('d/m/y',strtotime($formation->fin))}} </p>
                        </div>
                    @endforeach
                @endif
                <br>


                <!-- TABLEAU DES COMPETENCES -->

                <h5> Mes compétences </h5>

                @if(count($competences)==0)
                    <p> Pas de compétences communiquées </p>
                @else
                    @foreach($categories as $categorie)
                        <table class="table table-hover">
                            <tbody>
                            @endforeach
                            @foreach($competences as $competence)
                                <tr class="table-active">
                                    <th scope="row">{{$competence->nomCompetence}}</th>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                                 aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{$competence->niveauEstime}}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        @endif
                        <br>





                        <!-- EXPERIENCES PROFESSIONNELLES -->
                        @if(count($experiences)==0)
                            <h5> Je ne possède pas d'experience professionnelle </h5> <br>
                        @elseif(count($experiences)==1)
                            <h5> Experience professionnelle </h5> <br>
                        @else
                            <h5> Mes experiences professionnelles </h5> <br>
                        @endif
                        @foreach($experiences as $experience)
                            <div class="alert alert-dismissible alert-info">
                                <strong>{{$experience->nom}} à {{$experience->etablissement}}</strong> <br>
                                <p> du {{date('d/m/y',strtotime($experience->dateDebut))}} au {{date('d/m/y',strtotime($experience->dateFin))}} </p>
                                <p> {{$experience->resume}} </p>
                            </div>
                        @endforeach
                        <br>
                        <br>

                        <!-- LES CENTRES D'INTERET -->
                        <h5> Centres d'interet </h5>
                        @if(count($activites)==0)
                            <p> Pas de centres d'interet communiqués  </p>
                        @else
                            @foreach($activites as $activite)
                                <span class="badge badge-pill badge-info">{{$activite}}</span>
                            @endforeach
                        @endif
                        <br>

            </div>
        </div>
    </div>
@endsection

