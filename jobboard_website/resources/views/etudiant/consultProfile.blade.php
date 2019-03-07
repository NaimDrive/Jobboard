@extends('layouts.master')

@section('content')
    <link href="{{ asset('css/consultProfile.css') }}" rel="stylesheet">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-8">

                <!-- ENTETE PROFIL -->
                <div class="headerProfil">
                    <h1>Profil de {{$prenom}} {{$nom}}</h1> <br/>
                    <img src="{{asset($image)}}" title="photo de profil" width="150" height="150"/>
                </div>

                <!-- INFORMATIONS PERSONNELLES -->
                <br/>
                <div class="info">
                    <div class="gauche">
                        <div class="card border-primary mb-3" style="max-width: 20rem;">
                            <div class="card-header"><h5>IDENTITE</h5></div>
                            <div class="card-body">
                                <p class="card-text"> Civilité : {{$etudiant->civilite}} <br/>
                                    Nom : {{$nom}} <br/>
                                    Prenom : {{$prenom}} <br/>

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
                            @foreach($liens as $li)
                                <div class="border p-3 mt-3">
                                    <h5>{{ $li->nomReference }}</h5>
                                    <p>{{ $li->UrlReference }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <br>

                <!-- POSTES RECHERCHÉS  -->

                @if(count($recherche)==0)
                    <h5> Recherce de poste </h5>
                    <p> aucune recherche de poste </p>
                @elseif(count($recherche)==1)
                    <h5> Je recherche actuellement ce poste :  </h5> <br>
                    <div class="alert alert-dismissible alert-secondary">
                        <strong> {{$recherche->souhait}}</strong> du {{$recherche->dateDebut}} au {{$recherche->dateFin}} <br>
                        mobilité : {{$recherche->mobilite}}
                    </div>
                @else
                    <h5> Je recherche actuellement ces postes :  </h5> <br>
                    @foreach($recherche as $rech)
                        <div class="alert alert-dismissible alert-secondary">
                            <strong> {{$rech->souhait}}</strong> du {{$rech->dateDebut}} au {{$rech->dateFin}} <br>
                            mobilité : {{$rech->mobilite}}
                        </div>
                    @endforeach
                @endif
                <br>


                <!-- FORMATION  -->
                <h5> Ma formation </h5>
                @if(count($formation)==0)
                    <p> Pas de formation communiquée  </p>
                @else
                    @foreach($formation as $form)
                        <div class="alert alert-dismissible alert-info">
                            <strong> {{$form->natureFormation}} </strong> <br>
                            <p> lieu : {{$form->lieuFormation}} <br>
                                période : du {{$form->debut}} au {{$form->fin}} </p>
                        </div>
                    @endforeach
                @endif
                <br>


                <!-- TABLEAU DES COMPETENCES -->

                <h5> Mes compétences </h5>

                @if(count($nbCompetences)==0)
                    <p> Pas de compétences communiquées </p>
                @else
                    @foreach($categorie as $cat)
                        <table class="table table-hover">
                            <tbody>
                            @endforeach
                            @foreach($competences as $comp)
                                <tr class="table-active">
                                    <th scope="row">{{$comp->nomCompetence}}</th>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                                 aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: {{$niveau}}%"></div>
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
                        @foreach($experiences as $exp)
                            <div class="alert alert-dismissible alert-info">
                                <strong>{{$exp->nom}} à {{$exp->etablissement}}</strong> <br>
                                <p> du {{$exp->dateDebut}} au {{$exp->dateFin}} </p>
                                <p> {{$exp->resume}} </p>
                            </div>
                        @endforeach
                        <br>
                        <br>

                        <!-- LES CENTRES D'INTERET -->
                        <h5> Centres d'interet </h5>
                        @if(count($activite)==0)
                            <p> Pas de centres d'interet communiqués  </p>
                        @else
                            @foreach($activite as $act)
                                <span class="badge badge-pill badge-info">{{$act}}</span>
                            @endforeach
                        @endif
                        <br>

            </div>
        </div>
    </div>
@endsection

