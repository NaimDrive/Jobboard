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
                        </div>
                    </fieldset>



                <!-- DEBUT DU FORMULAIRE DES LIENS -->

                    <legend>Liens externes</legend>
                    <div id="liens">
                        <input type="hidden" name="nbLiens" id="compteur">
                        @php ($i = 0)
                        @foreach($lien as $l)
                            <div id="block_liens_{{$i}}" class="form-group ml-1">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="lien_{{$i}}" id="lien_{{$i}}" value="{{$l->UrlReference}}">
                                    </div>
                                    <div class="col-5">
                                        <select class="form-control" name="type_{{$i}}" id="type_{{$i}}">
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
                                        <button id="delete_{{$i}}" class="btn btn-danger" data-action="delete" data-target="block_liens_{{$i}}" type="button">X</button>
                                    </div>
                                </div>
                            </div>
                            @php ($i++)
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
    </div>

@endsection

@section('javaScript')
    <script>

        let boutonAddLien = document.getElementById('add-link'); //Bouton d'ajout de lien
        boutonAddLien.addEventListener('click' , addLinks); //On assigne la fonction d'ajout au bouton après click

        let divLiens = document.getElementById('liens');

        let index = parseInt(divLiens.childNodes.length)-(3+(parseInt({{$i}})));
        console.log('initialement ' + index);


        for(let k=0; k<index; k++){
            let bouton = document.getElementById('delete_'+k);
            bouton.addEventListener('click', supprimerLien);
        }

        document.getElementById("compteur").value=index;

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
            divFormGroup.setAttribute("id", "block_liens_"+index);

            let divRow = document.createElement("div");
            divRow.setAttribute("class", "row");

            let divCol6 = document.createElement("div");
            divCol6.setAttribute("class", 'col-6'); //emplacement input

            let divCol5 = document.createElement("div");
            divCol5.setAttribute("class",'col-5'); //emplacement input

            let divCol1 = document.createElement("div");
            divCol1.setAttribute("class", "col-1"); //bouton supprimer

            let inputLink = document.createElement("input");
            inputLink.setAttribute("id","lien_"+index);
            inputLink.setAttribute("name","lien_"+index);
            inputLink.setAttribute("type", "url");
            inputLink.setAttribute("class", "form-control");
            inputLink.setAttribute("placeholder", "Lien externe");

            let inputSelect = document.createElement("select");
            inputSelect.setAttribute("class","form-control");
            inputSelect.setAttribute("id","type_"+index);
            inputSelect.setAttribute("name","type_"+index);

            inputSelect.innerHTML+="<option value='Linkedin'>Linkedin</option><option value='GitHub'>GitHub</option><option value='Autre'>Autre</option>";

            let inputDelete = document.createElement("button");
            inputDelete.setAttribute("id", "delete_"+index);
            inputDelete.setAttribute("class", "btn btn-danger");
            inputDelete.setAttribute("data-action", "delete");
            inputDelete.setAttribute("data-target", "block_liens_"+index);
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

            let bouton = document.getElementById('delete_'+index);
            bouton.addEventListener('click', supprimerLien);

            document.getElementById("compteur").value = ++index;
            console.log('après ajout ' + index);
        }



        function supprimerLien(){
            let inputCompteur = document.getElementById("compteur");
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
                let inputDelete = document.getElementById("delete_"+(i+1));

                inputLien.setAttribute('name', "lien_"+i);
                inputLien.setAttribute('id', "lien_"+i);
                inputType.setAttribute('name',"type_"+i);
                inputType.setAttribute('id',"type_"+i);


                inputDelete.setAttribute('data-target', "block_liens_"+i);
                inputDelete.setAttribute('id', "delete_"+i);
            }

            inputCompteur.value -=1;
            index--;
            console.log('après suppression ' + index);
        }

        </script>
        @endsection