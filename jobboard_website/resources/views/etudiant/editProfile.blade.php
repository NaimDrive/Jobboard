@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger"  style="margin-top: 2rem">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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
                        </div>
                    </fieldset>



                    <!-- DEBUT DU FORMULAIRE DES COMPETENCES -->
                    <h1>Competences</h1>
                    <div id="competence">
                        <input type="hidden" name="nbCompetence" id="compteurCompetence">
                        @php ($comp = 0)
                        @foreach($competence as $c)
                            <div id="block_competence_{{$comp}}" class="form-group ml-1">
                                <div class="row">
                                    <input type="text" class="form-control" name="competence_{{$comp}}" id="competence_{{$comp}}" value="{{$c->nomCompetence}}">
                                    <select class="form-control" name="categorie_{{$comp}}" id="categorie_{{$comp}}">
                                        @foreach($categorie as $categ)
                                            @if($c->idCategorie == $categ->id )
                                                <option value="{{$categ->nomCategorie}}" selected>{{$categ->nomCategorie}}</option>
                                            @endif
                                                <option value="{{$categ->nomCategorie}}">{{$categ->nomCategorie}}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control" name="level_{{$comp}}" id="level_{{$comp}}">
                                        @if($c->niveauEstime == "Excellent")
                                            <option value="Excellent" selected>Excellent</option>
                                            <option value="Bon">Bon</option>
                                            <option value="Moyen">Moyen</option>
                                            <option value="Faible">Faible</option>
                                        @elseif($c->niveauEstime == "Bon")
                                            <option value="Excellent">Excellent</option>
                                            <option value="Bon" selected>Bon</option>
                                            <option value="Moyen">Moyen</option>
                                            <option value="Faible">Faible</option>
                                        @elseif($c->niveauEstime == "Moyen")
                                            <option value="Excellent">Excellent</option>
                                            <option value="Bon">Bon</option>
                                            <option value="Moyen" selected>Moyen</option>
                                            <option value="Faible">Faible</option>
                                        @else
                                            <option value="Excellent">Excellent</option>
                                            <option value="Bon">Bon</option>
                                            <option value="Moyen">Moyen</option>
                                            <option value="Faible" selected>Faible</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-1">
                                    <button id="deleteCompetence_{{$comp}}" class="btn btn-danger" data-action="delete" data-target="block_competence_{{$comp}}" type="button">X</button>
                                </div>
                            </div>
                            @php ($comp++)
                        @endforeach
                    </div>
                    <div class="form-group">
                        <button type="button" id="add-competence" class="btn btn-primary">Ajouter un lien</button>
                    </div>
                    <br>



                    <!-- DEBUT DU FORMULAIRE DES EXPERIENCES -->
            <h1>Expériences</h1>
            <div id="experience">
                <input type="hidden" name="nbExperience" id="compteurExperience">
                @php ($exp = 0)
                @foreach($experience as $e)
                    <div id="block_experience_{{$exp}}" class="form-group ml-1">
                        <div class="row">
                            <input type="text" class="form-control" name="experience_{{$exp}}" id="experience_{{$exp}}" value="{{$e->nom}}">
                            <input type="text" class="form-control" name="etablissement_{{$exp}}" id="etablissement_{{$exp}}" value="{{$e->etablissement}}">
                            <div class="row">
                                <div class="col-6"><input type="date" class="form-control" name="dateDebut_{{$exp}}" id="dateDebut_{{$exp}}" value="{{$e->dateDebut}}"></div>
                                <div class="col-6"><input type="date" class="form-control" name="dateFin_{{$exp}}" id="dateFin_{{$exp}}" value="{{$e->dateFin}}"></div>
                            </div>
                            <textarea class="form-control" id="description_{{$exp}}" name="description_{{$exp}}" rows="5" style="resize: none;">{{$e->resume}}</textarea>
                            <div class="col-1">
                                <button id="deleteExperience_{{$exp}}" class="btn btn-danger" data-action="delete" data-target="block_experience_{{$exp}}" type="button">X</button>
                            </div>
                        </div>
                    </div>
                    @php ($exp++)
                @endforeach
            </div>
            <div class="form-group">
                <button type="button" id="add-experience" class="btn btn-primary">Ajouter une expérience</button>
            </div>
            <br>


                    <!-- DEBUT DU FORMULAIRE DE CENTRES D INTERET -->
            <h1>Activités</h1>
            <div id="activite">
                <input type="hidden" name="nbActivite" id="compteurActivite">
                @php ($act = 0)
                @foreach($activite as $a)
                    <div id="block_activite_{{$act}}" class="form-group ml-1">
                        <div class="row">
                            <div class="col-11">
                                <input type="text" class="form-control" name="activite_{{$act}}" id="activite_{{$act}}" value="{{$a->Interet}}">
                            </div>
                            <div class="col-1">
                                <button id="deleteActivite_{{$act}}" class="btn btn-danger" data-action="delete" data-target="block_activite_{{$act}}" type="button">X</button>
                            </div>
                        </div>
                    </div>
                    @php ($act++)
                @endforeach
            </div>
            <div class="form-group">
                <button type="button" id="add-activite" class="btn btn-primary">Ajouter une activité</button>
            </div>
            <br>


                <!-- DEBUT DU FORMULAIRE DES LIENS -->
            <h1>Liens externes</h1>
            <div id="liens">
                <input type="hidden" name="nbLiens" id="compteurLien">
                @php ($li = 0)
                @foreach($lien as $l)
                    <div id="block_liens_{{$li}}" class="form-group ml-1">
                        <div class="row">
                            <div class="col-6">
                                <input type="text" class="form-control" name="lien_{{$li}}" id="lien_{{$li}}" value="{{$l->UrlReference}}">
                            </div>
                            <div class="col-5">
                                <select class="form-control" name="type_{{$li}}" id="type_{{$li}}">
                                    @if($l->nomReference == "Linkedin")
                                        <option value="Linkedin" selected>Linkedin</option>
                                        <option value="GitHub">GitHub</option>
                                        <option value="Autre">Autre</option>
                                    @elseif($l->nomReference == "GitHub")
                                        <option value="Linkedin">Linkedin</option>
                                        <option value="GitHub" selected>GitHub</option>
                                        <option value="Autre">Autre</option>
                                    @else
                                        <option value="Linkedin">Linkedin</option>
                                        <option value="GitHub">GitHub</option>
                                        <option value="Autre" selected>Autre</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-1">
                                <button id="deleteLien_{{$li}}" class="btn btn-danger" data-action="delete" data-target="block_liens_{{$li}}" type="button">X</button>
                            </div>
                        </div>
                    </div>
                    @php ($li++)
                @endforeach
            </div>
                    <div class="form-group">
                <button type="button" id="add-link" class="btn btn-primary">Ajouter un lien</button>
            </div>
                    <br>
                    <div class="row justify-content-md-center">
                        <button type="submit" class="col-lg-4 btn btn-success">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>


@endsection

@section('javaScript')
    <script>

        let boutonAddLien = document.getElementById('add-link'); //Bouton d'ajout de lien
        boutonAddLien.addEventListener('click' , addLinks); //On assigne la fonction d'ajout au bouton après click

        let boutonAddActivite = document.getElementById('add-activite'); //Bouton d'ajout d'activite
        boutonAddActivite.addEventListener('click' , addActivite); //On assigne la fonction d'ajout au bouton après click

        let boutonAddExperience = document.getElementById('add-experience'); //Bouton d'ajout d'experience
        boutonAddExperience.addEventListener('click' , addExperience); //On assigne la fonction d'ajout au bouton après click

        let boutonAddCompetence = document.getElementById('add-competence'); //Bouton d'ajout de competence
        boutonAddCompetence.addEventListener('click' , addCompetence); //On assigne la fonction d'ajout au bouton après click

        let divLiens = document.getElementById('liens');
        let divActivite = document.getElementById('activite');
        let divExperience = document.getElementById('experience');
        let divCompetence = document.getElementById('competence');

        let indexLien = parseInt(divLiens.childNodes.length)-(3+(parseInt({{$li}})));
        let indexActivite = parseInt(divActivite.childNodes.length)-(3+(parseInt({{$act}})));
        let indexExperience = parseInt(divExperience.childNodes.length)-(3+(parseInt({{$exp}})));
        let indexCompetence = parseInt(divCompetence.childNodes.length)-(3+(parseInt({{$comp}})));
        //console.log('initialement ' + index);


        for(let k=0; k<indexLien; k++){
            let bouton = document.getElementById('deleteLien_'+k);
            bouton.addEventListener('click', supprimerLien);
        }
        for(let l=0; l<indexActivite; l++){
            let bouton = document.getElementById('deleteActivite_'+l);
            bouton.addEventListener('click', supprimerActivite);
        }
        for(let m=0; m<indexExperience; m++){
            let bouton = document.getElementById('deleteExperience_'+m);
            bouton.addEventListener('click', supprimerExperience);
        }
        for(let n=0; n<indexCompetence; n++){
            let bouton = document.getElementById('deleteCompetence_'+n);
            bouton.addEventListener('click', supprimerCompetence);
        }

        document.getElementById("compteurLien").value=indexLien;
        document.getElementById("compteurActivite").value=indexActivite;
        document.getElementById("compteurExperience").value=indexExperience;
        document.getElementById("compteurCompetence").value=indexCompetence;


        //AJOUT DES COMPETENCES


        function addCompetence () {

            /*A partir d'ici, on crée la structure suivante :

            <div class="form-group m1-1">
                <div class="row">
                    <div class="col-6"> contenu </div>
                    <div class="col-5"> contenu </div>
                    <div class="col-1"> contenu </div>
                </div>
            </div>

             */

            let divFormGroup = document.createElement("div");
            divFormGroup.setAttribute("class", "form-group ml-1");
            divFormGroup.setAttribute("id", "block_competence_"+indexCompetence);

            let divRow = document.createElement("div");
            divRow.setAttribute("class", "row");

            let divCol1 = document.createElement("div");
            divCol1.setAttribute("class", "col-1"); //bouton supprimer

            let inputComp = document.createElement("input");
            inputComp.setAttribute("id","competence_"+indexCompetence);
            inputComp.setAttribute("name","competence_"+indexCompetence);
            inputComp.setAttribute("type", "text");
            inputComp.setAttribute("class", "form-control");
            inputComp.setAttribute("placeholder", "Competence");

            let inputSelectCategorie = document.createElement("select");
            inputSelectCategorie.setAttribute("class","form-control");
            inputSelectCategorie.setAttribute("id","categorie_"+indexCompetence);
            inputSelectCategorie.setAttribute("name","categorie_"+indexCompetence);

            let inputSelectLevel = document.createElement("select");
            inputSelectLevel.setAttribute("class","form-control");
            inputSelectLevel.setAttribute("id","level_"+indexCompetence);
            inputSelectLevel.setAttribute("name","level_"+indexCompetence);

            inputSelectCategorie.innerHTML="@foreach($categorie as $c)<option value='{{$c->nomCategorie}}'>{{$c->nomCategorie}}</option>@endforeach";

            inputSelectLevel.innerHTML="<option value='Excellent'>Excellent</option><option value='Bon'>Bon</option><option value='Moyen'>Moyen</option><option value='Faible'>Faible</option>";


            let inputDelete = document.createElement("button");
            inputDelete.setAttribute("id", "deleteCompetence_"+indexCompetence);
            inputDelete.setAttribute("class", "btn btn-danger");
            inputDelete.setAttribute("data-action", "delete");
            inputDelete.setAttribute("data-target", "block_competence_"+indexCompetence);
            inputDelete.setAttribute("type", "button");

            let X = document.createTextNode("X");
            inputDelete.appendChild(X);

            divCol1.appendChild(inputDelete);

            divRow.appendChild(inputComp);
            divRow.appendChild(inputSelectCategorie);
            divRow.appendChild(inputSelectLevel);
            divRow.appendChild(divCol1);

            divFormGroup.appendChild(divRow);

            divCompetence.appendChild(divFormGroup);

            let bouton = document.getElementById('deleteCompetence_'+indexCompetence);
            bouton.addEventListener('click', supprimerCompetence);

            document.getElementById("compteurCompetence").value = ++indexCompetence;
            console.log('après ajout ' + indexCompetence);
        }

        function supprimerCompetence(){
            let inputCompteur = document.getElementById("compteurCompetence");
            let compteur = parseInt(inputCompteur.value)-1;
            let target = this.dataset.target;
            let divSupprimer = document.getElementById(target);
            let id = parseInt(target.substr(17));
            console.log('id = ' + id);

            document.getElementById("competence").removeChild(divSupprimer);



            for(let i = id; i < compteur; i++){
                let div =document.getElementById("block_competence_"+(i+1));
                div.setAttribute('id', "block_competence_"+i);

                let inputCompetence = document.getElementById("competence_"+(i+1));
                let inputCategorie = document.getElementById("categorie_"+(i+1));
                let inputLevel = document.getElementById("level_"+(i+1));
                let inputDelete = document.getElementById("deleteCompetence_"+(i+1));

                inputCompetence.setAttribute('name', "competence_"+i);
                inputCompetence.setAttribute('id', "competence_"+i);

                inputCategorie.setAttribute('name',"categorie_"+i);
                inputCategorie.setAttribute('id',"categorie_"+i);

                inputLevel.setAttribute('name',"level_"+i);
                inputLevel.setAttribute('id',"level_"+i);


                inputDelete.setAttribute('data-target', "block_competence_"+i);
                inputDelete.setAttribute('id', "deleteCompetence_"+i);
            }

            inputCompteur.value -=1;
            indexCompetence--;
            console.log('après suppression ' + indexCompetence);
        }



        //AJOUT DES EXPERIENCES


        function addExperience () {

            /*A partir d'ici, on crée la structure suivante :

            <div class="form-group m1-1">
                <div class="row">
                    <div class="col-11"> contenu </div>
                    <div class="col-1"> contenu </div>
                </div>
            </div>

             */

            let divFormGroup = document.createElement("div");
            divFormGroup.setAttribute("class", "form-group ml-1");
            divFormGroup.setAttribute("id", "block_experience_"+indexExperience);

            let divRow = document.createElement("div");
            divRow.setAttribute("class", "row");

            let divRow_sous = document.createElement("div");
            divRow_sous.setAttribute("class", "row");

            let divCol6_debut = document.createElement("div");
            divCol6_debut.setAttribute("class", 'col-6');

            let divCol6_fin = document.createElement("div");
            divCol6_fin.setAttribute("class", 'col-6');

            let divCol1 = document.createElement("div");
            divCol1.setAttribute("class", "col-1"); //bouton supprimer

            let inputExperience = document.createElement("input");
            inputExperience.setAttribute("id","experience_"+indexExperience);
            inputExperience.setAttribute("name","experience_"+indexExperience);
            inputExperience.setAttribute("type", "text");
            inputExperience.setAttribute("class", "form-control");
            inputExperience.setAttribute("placeholder", "Experience");

            let inputEtablissement = document.createElement("input");
            inputEtablissement.setAttribute("id","etablissement_"+indexExperience);
            inputEtablissement.setAttribute("name","etablissement_"+indexExperience);
            inputEtablissement.setAttribute("type", "text");
            inputEtablissement.setAttribute("class", "form-control");
            inputEtablissement.setAttribute("placeholder", "etablissement");

            let inputDateDeb = document.createElement("input");
            inputDateDeb.setAttribute("id","dateDebut_"+indexExperience);
            inputDateDeb.setAttribute("name","dateDebut_"+indexExperience);
            inputDateDeb.setAttribute("type","date");
            inputDateDeb.setAttribute("class", "form-control");

            let inputDateFin = document.createElement("input");
            inputDateFin.setAttribute("id","dateFin_"+indexExperience);
            inputDateFin.setAttribute("name","dateFin_"+indexExperience);
            inputDateFin.setAttribute("type","date");
            inputDateFin.setAttribute("class", "form-control");

            let inputDesc = document.createElement("textarea");
            inputDesc.setAttribute("id","description_"+indexExperience);
            inputDesc.setAttribute("name","description_"+indexExperience);
            inputDesc.setAttribute("class", "form-control");
            inputDesc.setAttribute("row", "5");
            inputDesc.setAttribute("style", "resize: none");

            let inputDelete = document.createElement("button");
            inputDelete.setAttribute("id", "deleteExperience_"+indexExperience);
            inputDelete.setAttribute("class", "btn btn-danger");
            inputDelete.setAttribute("data-action", "delete");
            inputDelete.setAttribute("data-target", "block_experience_"+indexExperience);
            inputDelete.setAttribute("type", "button");

            let X = document.createTextNode("X");
            inputDelete.appendChild(X);

            divCol6_debut.appendChild(inputDateDeb);
            divCol6_fin.appendChild(inputDateFin);

            divRow_sous.appendChild(divCol6_debut);
            divRow_sous.appendChild(divCol6_fin);
            divRow.appendChild(inputExperience);
            divRow.appendChild(inputEtablissement);
            divRow.appendChild(divRow_sous);
            divRow.appendChild(inputDesc);
            divRow.appendChild(inputDelete);


            divFormGroup.appendChild(divRow);

            divExperience.appendChild(divFormGroup);

            let bouton = document.getElementById('deleteExperience_'+indexExperience);
            bouton.addEventListener('click', supprimerExperience);

            document.getElementById("compteurExperience").value = ++indexExperience;
            console.log('après ajout ' + indexExperience);
        }


        function supprimerExperience(){
            let inputCompteur = document.getElementById("compteurExperience");
            let compteur = parseInt(inputCompteur.value)-1;
            let target = this.dataset.target;
            let divSupprimer = document.getElementById(target);
            let id = parseInt(target.substr(17));
            console.log('id = ' + id);

            document.getElementById("experience").removeChild(divSupprimer);

            for(let i = id; i < compteur; i++){
                let div =document.getElementById("block_experience_"+(i+1));
                div.setAttribute('id', "block_experience_"+i);

                let inputExperience = document.getElementById("experience_"+(i+1));
                let inputEtablissement = document.getElementById("etablissement_"+(i+1));
                let inputDesc = document.getElementById("description_"+(i+1));
                let inputDateDeb = document.getElementById("dateDebut_"+(i+1));
                let inputDateFin = document.getElementById("dateFin_"+(i+1));
                let inputDelete = document.getElementById("deleteExperience_"+(i+1));

                inputExperience.setAttribute('name', "experience_"+i);
                inputExperience.setAttribute('id', "experience_"+i);

                inputEtablissement.setAttribute('name', "etablissement_"+i);
                inputEtablissement.setAttribute('id', "etablissement_"+i);

                inputDesc.setAttribute('name', "description_"+i);
                inputDesc.setAttribute('id', "description_"+i);

                inputDateDeb.setAttribute('name', "dateDebut_"+i);
                inputDateDeb.setAttribute('id', "dateDebut_"+i);

                inputDateFin.setAttribute('name', "dateFin_"+i);
                inputDateFin.setAttribute('id', "dateFin_"+i);

                inputDelete.setAttribute('data-target', "block_experience_"+i);
                inputDelete.setAttribute('id', "deleteExperience_"+i);
            }

            inputCompteur.value -=1;
            indexExperience--;
            console.log('après suppression ' + indexExperience);
        }


        //AJOUT DE CENTRES D INTERET


        function addActivite () {

            /*A partir d'ici, on crée la structure suivante :

            <div class="form-group m1-1">
                <div class="row">
                    <div class="col-11"> contenu </div>
                    <div class="col-1"> contenu </div>
                </div>
            </div>

             */

            let divFormGroup = document.createElement("div");
            divFormGroup.setAttribute("class", "form-group ml-1");
            divFormGroup.setAttribute("id", "block_activite_"+indexActivite);

            let divRow = document.createElement("div");
            divRow.setAttribute("class", "row");

            let divCol11 = document.createElement("div");
            divCol11.setAttribute("class", 'col-11'); //emplacement input

            let divCol1 = document.createElement("div");
            divCol1.setAttribute("class", "col-1"); //bouton supprimer

            let inputActivite = document.createElement("input");
            inputActivite.setAttribute("id","activite_"+indexActivite);
            inputActivite.setAttribute("name","activite_"+indexActivite);
            inputActivite.setAttribute("type", "text");
            inputActivite.setAttribute("class", "form-control");
            inputActivite.setAttribute("placeholder", "Activite");

            let inputDelete = document.createElement("button");
            inputDelete.setAttribute("id", "deleteActivite_"+indexActivite);
            inputDelete.setAttribute("class", "btn btn-danger");
            inputDelete.setAttribute("data-action", "delete");
            inputDelete.setAttribute("data-target", "block_activite_"+indexActivite);
            inputDelete.setAttribute("type", "button");

            let X = document.createTextNode("X");
            inputDelete.appendChild(X);

            divCol1.appendChild(inputDelete);
            divCol11.appendChild(inputActivite);

            divRow.appendChild(divCol11);
            divRow.appendChild(divCol1);

            divFormGroup.appendChild(divRow);

            divActivite.appendChild(divFormGroup);

            let bouton = document.getElementById('deleteActivite_'+indexActivite);
            bouton.addEventListener('click', supprimerActivite);

            document.getElementById("compteurActivite").value = ++indexActivite;
            console.log('après ajout ' + indexActivite);
        }


        function supprimerActivite(){
            let inputCompteur = document.getElementById("compteurActivite");
            let compteur = parseInt(inputCompteur.value)-1;
            let target = this.dataset.target;
            let divSupprimer = document.getElementById(target);
            let id = parseInt(target.substr(15));
            console.log('id = ' + id);

            document.getElementById("activite").removeChild(divSupprimer);

            for(let i = id; i < compteur; i++){
                let div =document.getElementById("block_activite_"+(i+1));
                div.setAttribute('id', "block_activite_"+i);

                let inputActivite = document.getElementById("activite_"+(i+1));
                let inputDelete = document.getElementById("deleteActivite_"+(i+1));

                inputActivite.setAttribute('name', "activite_"+i);
                inputActivite.setAttribute('id', "activite_"+i);

                inputDelete.setAttribute('data-target', "block_activite_"+i);
                inputDelete.setAttribute('id', "deleteActivite_"+i);
            }

            inputCompteur.value -=1;
            indexActivite--;
            console.log('après suppression ' + indexActivite);
        }


        //AJOUT DE LIENS


        function addLinks () {

            /*A partir d'ici, on crée la structure suivante :

            <div class="form-group m1-1">
                <div class="row">
                    <div class="col-6"> contenu </div>
                    <div class="col-5"> contenu </div>
                    <div class="col-1"> contenu </div>
                </div>
            </div>

             */

            let divFormGroup = document.createElement("div");
            divFormGroup.setAttribute("class", "form-group ml-1");
            divFormGroup.setAttribute("id", "block_liens_"+indexLien);

            let divRow = document.createElement("div");
            divRow.setAttribute("class", "row");

            let divCol6 = document.createElement("div");
            divCol6.setAttribute("class", 'col-6'); //emplacement input

            let divCol5 = document.createElement("div");
            divCol5.setAttribute("class",'col-5'); //emplacement input

            let divCol1 = document.createElement("div");
            divCol1.setAttribute("class", "col-1"); //bouton supprimer

            let inputLink = document.createElement("input");
            inputLink.setAttribute("id","lien_"+indexLien);
            inputLink.setAttribute("name","lien_"+indexLien);
            inputLink.setAttribute("type", "url");
            inputLink.setAttribute("class", "form-control");
            inputLink.setAttribute("placeholder", "Lien externe");

            let inputSelect = document.createElement("select");
            inputSelect.setAttribute("class","form-control");
            inputSelect.setAttribute("id","type_"+indexLien);
            inputSelect.setAttribute("name","type_"+indexLien);

            inputSelect.innerHTML+="<option value='Linkedin'>Linkedin</option><option value='GitHub'>GitHub</option><option value='Autre'>Autre</option>";

            let inputDelete = document.createElement("button");
            inputDelete.setAttribute("id", "deleteLien_"+indexLien);
            inputDelete.setAttribute("class", "btn btn-danger");
            inputDelete.setAttribute("data-action", "delete");
            inputDelete.setAttribute("data-target", "block_liens_"+indexLien);
            inputDelete.setAttribute("type", "button");

            let X = document.createTextNode("X");
            inputDelete.appendChild(X);

            divCol1.appendChild(inputDelete);
            divCol6.appendChild(inputLink);
            divCol5.appendChild(inputSelect);

            divRow.appendChild(divCol6);
            divRow.appendChild(divCol5);
            divRow.appendChild(divCol1);

            divFormGroup.appendChild(divRow);

            divLiens.appendChild(divFormGroup);

            let bouton = document.getElementById('deleteLien_'+indexLien);
            bouton.addEventListener('click', supprimerLien);

            document.getElementById("compteurLien").value = ++indexLien;
            console.log('après ajout ' + indexLien);
        }

        function supprimerLien(){
            let inputCompteur = document.getElementById("compteurLien");
            let compteur = parseInt(inputCompteur.value)-1;
            let target = this.dataset.target;
            let divSupprimer = document.getElementById(target);
            let id = parseInt(target.substr(12));
            console.log('id = ' + id);

            document.getElementById("liens").removeChild(divSupprimer);



            for(let i = id; i < compteur; i++){
                let div =document.getElementById("block_liens_"+(i+1));
                div.setAttribute('id', "block_liens_"+i);

                let inputLien = document.getElementById("lien_"+(i+1));
                let inputType = document.getElementById("type_"+(i+1));
                let inputDelete = document.getElementById("deleteLien_"+(i+1));

                inputLien.setAttribute('name', "lien_"+i);
                inputLien.setAttribute('id', "lien_"+i);
                inputType.setAttribute('name',"type_"+i);
                inputType.setAttribute('id',"type_"+i);


                inputDelete.setAttribute('data-target', "block_liens_"+i);
                inputDelete.setAttribute('id', "deleteLien_"+i);
            }

            inputCompteur.value -=1;
            indexLien--;
            console.log('après suppression ' + indexLien);
        }

        </script>
        @endsection
