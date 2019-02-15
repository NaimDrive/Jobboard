@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-6">

                <!-- DEBUT DU FORMULAIRE DE PHOTO DE PROFILE -->

                <form>
                    {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
                    <fieldset>
                        <legend>Photo de profile</legend>
                        <div class="form-group">
                            <input type="file" class="form-control-file" id="exampleInputFile" value="{{old("exampleInputFile")}}" aria-describedby="fileHelp">
                        </div>
                    </fieldset>
                </form>

                <!-- DEBUT DU FORMULAIRE D' IDENTITE -->



                <form method="POST" action="{{route('enregistrer_identite')}}">
                    {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
                    <fieldset>
                        <legend>Identité</legend>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6"><input type="text" class="form-control" id="nom" name="nom" value="{{old("nom")}}" aria-describedby="infoComp" placeholder="Nom"></div>
                                <div class="col-lg-6"><input type="text" class="form-control" id="prenom" name="prenom" value="{{old("prenom")}}" aria-describedby="infoComp" placeholder="Prenom"></div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>
                </form>

                <!-- DEBUT DU FORMULAIRE DE COMPETENCES -->

                <legend>Compétences</legend>
                <br>
                @if(count($competence)!==0) <!-- On vérifie qu'il y a au moins une compétence pour afficher le tableau... -->
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Competences</th>
                        <th scope="col">Niveau</th>
                        <th scope="col">Suppression</th>
                    </tr>
                    </thead>
                    @foreach($competence as $comp) <!-- On génère pour chaque compétence une ligne avec le nom, le niveau et un bouton de suppression -->
                        <tbody>
                        <tr>
                            <form method="POST" action="{{route('supprimer_competence')}}">
                                {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
                            <th scope="row">{{$comp->nomCompetence}}</th>
                            <td>{{$comp->niveauEstime}}</td>
                            <td><button type="submit" class="btn btn-danger col-lg-8" id="competence_del" name="competence_del" value="{{$comp->nomCompetence}}">X</button></td>
                            </form>
                        </tr>
                        </tbody>
                        @endforeach
                </table>
                    <br>
                @endif


                <form method="POST" action="{{route('enregistrer_competence')}}">
                    {!! csrf_field() !!}
                    <fieldset>
                        <div class="form-group">
                            <input type="text" class="form-control" id="competence" name="competence" value="{{old("competence")}}" aria-describedby="infoComp" placeholder="Exemple: Javascript">
                            <br>
                            <label for="level">Niveau estimé</label>
                            <select class="form-control" id="level" name="level" value="{{old("level")}}">
                                <option>Excellent</option>
                                <option>Bon</option>
                                <option>Moyen</option>
                                <option>Faible</option>
                            </select>
                            <br>
                            <label for="categorie">Catégorie</label>
                            <select class="form-control" id="categorie" name="categorie" value="{{old("categorie")}}" >
                                @foreach($categorie as $c) <!-- On génère pour chaque catégorie une option. Si on insère une catégorie dans la table, elle apparait ici -->
                                    <option>{{$c}}</option>
                                @endforeach
                            </select>
                            <small id="infoComp" class="form-text text-muted">Vos compétences seront visibles sur votre profile</small><br> <!-- petit texte indicatif -->
                            <button type="submit" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>
                </form>

                <!-- DEBUT DU FORMULAIRE D'EXPERIENCES -->

                <form method="POST" action="{{route('enregistrer_experience')}}">
                    {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
                    <fieldset>
                        <legend>Expériences</legend>
                        <div class="form-group">
                            <input type="text" class="form-control" id="intitulePoste" name="intitulePoste" value="{{old("intitulePoste")}}" placeholder="Intitulé du poste (exemple: développeur Web)">
                            <br>
                            <input type="text" class="form-control" id="etablissement" name="etablissement" value="{{old("etablissement")}}" placeholder="Nom de l'entreprise">
                            <br>
                            <div class="row">
                                <!-- A MODIFIER CAR INPUT TYPE DATE NON PRIS EN CHARGE PAR SAFARI -->
                                <div class="col-lg-6">Date de début<input type="date" class="form-control" id="dateDebut" name="dateDebut" value="{{old("dateDebut")}}"></div>
                                <div class="col-lg-6">Date de fin<input type="date" class="form-control" id="dateFin" name="dateFin" value="{{old("dateFin")}}"></div>
                            </div>
                            <br>
                            <label for="description">Description du poste</label>
                            <textarea class="form-control" id="description" name="description" value="{{old("description")}}" rows="5" style="resize: none;"></textarea><br>
                            <button type="submit" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>
                </form>

                <!-- DEBUT DU FORMULAIRE DE CENTRES D INTERET -->

                <form method="POST" action="{{route('enregistrer_activite')}}">
                    {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
                    <fieldset>
                        <legend>Centres d'intérêt</legend>
                        <div class="form-group">
                            <input type="text" class="form-control" id="activite" name="activite" value="{{old("activite")}}" placeholder="Exemple: Sport"><br>
                            <button type="submit" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

@endsection