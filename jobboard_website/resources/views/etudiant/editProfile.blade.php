@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-6">

                <!-- DEBUT DU FORMULAIRE DE PHOTO DE PROFILE -->

                <img src="{{asset($user->picture)}}" alt="photo de profile" width="500" height="500"/>

                <form enctype="multipart/form-data" method="POST" action="{{route('enregistrer_modifs')}}">
                    <input id="idEtu" name="idEtu" type="hidden" value={{$id}}>
                    {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
                    <fieldset>
                        <legend>Photo de profile</legend>
                        <div class="form-group">
                            <input type="file" class="form-control-file" id="photo" name="photo">
                            <br>
                            <button type="submit" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>

                <!-- DEBUT DU FORMULAIRE D' IDENTITE -->



                    <fieldset>
                        <legend>Identité</legend>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6"><input type="text" class="form-control" id="nom" name="nom" value="{{$user->nom}}" aria-describedby="infoComp" placeholder="Nom"></div>
                                <div class="col-lg-6"><input type="text" class="form-control" id="prenom" name="prenom" value="{{$user->prenom}}" aria-describedby="infoComp" placeholder="Prenom"></div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>

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
                                {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
                            <th scope="row">{{$comp->nomCompetence}}</th>
                            <td>{{$comp->niveauEstime}}</td>
                            <td><button type="submit" class="btn btn-danger col-lg-8" id="competence_del" name="competence_del" value="{{$comp->nomCompetence}}">X</button></td>
                        </tr>
                        </tbody>
                        @endforeach
                </table>
                    <br>
                @endif


                    <fieldset>
                        <div class="form-group">
                            <input type="text" class="form-control" id="competence" name="competence" value="" aria-describedby="infoComp" placeholder="Exemple: Javascript">
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
                            <select class="form-control" id="categorie" name="categorie" value={{old("categorie")}} >
                                @foreach($categorie as $c) <!-- On génère pour chaque catégorie une option. Si on insère une catégorie dans la table, elle apparait ici -->
                                    <option>{{$c}}</option>
                                @endforeach
                            </select>
                            <small id="infoComp" class="form-text text-muted">Vos compétences seront visibles sur votre profile</small><br> <!-- petit texte indicatif -->
                            <button type="submit" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>

                <!-- DEBUT DU FORMULAIRE D'EXPERIENCES -->


                <legend>Expériences</legend>
                <br>
                @if(count($experience)!==0) <!-- On vérifie qu'il y a au moins une experience pour afficher le tableau... -->
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Poste</th>
                        <th scope="col">Date de Debut</th>
                        <th scope="col">Date de Fin</th>
                        <th scope="col">Etablissement</th>
                        <th scope="col">Suppression</th>
                    </tr>
                    </thead>
                @foreach($experience as $exp) <!-- On génère pour chaque experience une ligne avec le nom, le niveau et un bouton de suppression -->
                    <tbody>
                    <tr>
                            <th scope="row">{{$exp->nom}}</th>
                            <td>{{$exp->dateDebut}}</td>
                            <td>{{$exp->dateFin}}</td>
                            <td>{{$exp->etablissement}}</td>
                            <td><button type="submit" class="btn btn-danger col-lg-8" id="experience_del" name="experience_del" value="{{$exp->nom}}">X</button></td>
                    </tr>
                    </tbody>
                    @endforeach
                </table>
                <br>
                @endif


                    <fieldset>
                        <div class="form-group">
                            <input type="text" class="form-control" id="intitulePoste" name="intitulePoste" value="" placeholder="Intitulé du poste (exemple: développeur Web)">
                            <br>
                            <input type="text" class="form-control" id="etablissement" name="etablissement" value="" placeholder="Nom de l'entreprise">
                            <br>
                            <div class="row">
                                <!-- A MODIFIER CAR INPUT TYPE DATE NON PRIS EN CHARGE PAR SAFARI -->
                                <div class="col-lg-6">Date de début<input type="date" class="form-control" id="dateDebut" name="dateDebut" value="0001-01-01"></div>
                                <div class="col-lg-6">Date de fin<input type="date" class="form-control" id="dateFin" name="dateFin" value="0001-01-01"></div>
                            </div>
                            <br>
                            <label for="description">Description du poste</label>
                            <textarea class="form-control" id="description" name="description" rows="5" style="resize: none;"></textarea><br>
                            <button type="submit" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>


                <!-- DEBUT DU FORMULAIRE DE CENTRES D INTERET -->

                <br>
                @if(count($activite)!==0) <!-- On vérifie qu'il y a au moins une activite pour afficher le tableau... -->
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Nom activite</th>
                        <th scope="col">Suppression</th>
                    </tr>
                    </thead>
                @foreach($activite as $ac) <!-- On génère pour chaque activite une ligne avec le nom et un bouton de suppression -->
                    <tbody>
                    <tr>
                            <th scope="row">{{$ac}}</th>
                            <td><button type="submit" class="btn btn-danger col-lg-8" id="activite_del" name="activite_del" value="{{$ac}}">X</button></td>
                    </tr>
                    </tbody>
                    @endforeach
                </table>
                <br>
                @endif


                    <fieldset>
                        <legend>Centres d'intérêt</legend>
                        <div class="form-group">
                            <input type="text" class="form-control" id="activite" name="activite" value="{{old("activite")}}" placeholder="Exemple: Sport"><br>
                            <button type="submit" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>



                <!-- DEBUT DU FORMULAIRE DES LIENS -->


                    <div id="liens">
                        <input type="hidden" name="nbLiens" id="compteur">
                        <fieldset>
                            <legend>Liens externes</legend>
                            <div class="block_liens_0">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="lien_0" name="lien_0" placeholder="Lien externe">
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="form-group">
                        <button type="button" id="add-link" class="btn btn-primary">Ajouter un lien</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('javaScript')
    <script>

        let boutonAddLien = document.getElementById('add-link');
        boutonAddLien.addEventListener('click' , addLinks);

        function addLinks () {

            let divLiens = document.getElementById('liens');
            let index = parseInt(divLiens.childNodes.length)-4;

            let divFormGroup = document.createElement("div");
            divFormGroup.setAttribute("class", "form-group ml-1");
            divFormGroup.setAttribute("id", "block_liens_"+index);

            let divRow = document.createElement("div");
            divRow.setAttribute("class", "row");

            let divCol11 = document.createElement("div");
            divCol11.setAttribute("class", 'col-11');

            let divCol1 = document.createElement("div");
            divCol1.setAttribute("class", "col-1");

            let inputLink = document.createElement("input");
            inputLink.setAttribute("id","lien_"+index);
            inputLink.setAttribute("name","lien_"+index);
            inputLink.setAttribute("type", "text");
            inputLink.setAttribute("placeholder", "Lien externe");

            let X = document.createTextNode("X");
            inputDelete.appendChild(X);

            divCol1.appendChild(inputDelete);
            divCol11.appendChild(inputLink);

            divRow.appendChild(divCol11);
            divRow.appendChild(divCol1);

            divFormGroup.appendChild(divRow);

            divLiens.appendChild(divFormGroup);

            let bouton = document.getElementById('delete_'+index);
            bouton.addEventListener('click', supprimerLien);

            document.getElementById("compteur").value = index+1;
        }

        function supprimerLien(){
            let inputCompteur = document.getElementById("compteur");
            let compteur = parseInt(inputCompteur.value)-1;
            let target = this.dataset.target;
            let divSupprimer = document.getElementById(target);

            let id = parseInt(target.substr(14,1));

            document.getElementById("liens").removeChild(divSupprimer);

            for(let i = id; i < compteur; i++){
                let div =document.getElementById("block_liens_"+(i+1));
                div.setAttribute('id', "block_liens_"+i);

                let inputLien = document.getElementById("lien_"+(i+1));
                let inputDelete = document.getElementById("delete_"+(i+1));

                inputLien.setAttribute('name', "lien_"+i);
                inputLien.setAttribute('id', "lien_"+i);


                inputDelete.setAttribute('data-target', "block_liens_"+i);
                inputDelete.setAttribute('id', "delete_"+i);
            }

            inputCompteur.value -=1;
        }

        document.getElementById("compteur").value = 1;
        </script>
        @endsection