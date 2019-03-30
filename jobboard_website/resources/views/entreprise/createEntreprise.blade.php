@extends('layouts.master')

@section('content')

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
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Inscrire mon entreprise</h1>
                    </div>
                    <div class="card-body">
                        <form method='POST' action="{{route('enregistrerEntreprise')}}">
                            {!! csrf_field() !!}
                            <div class="form-group row">
                                <label for="nom" class="col-md-4 col-form-label text-md-right">
                                    Raison sociale
                                </label>
                                <input type="text" id="nom" name="nom" value="{{old("nom")}}" class="form-control col-md-6" placeholder="Nom de l'entreprise" required>
                            </div>

                            <div class="form-group row">
                                <label for="siret" class="col-md-4 col-form-label text-md-right">
                                    SIRET
                                </label>
                                <input type="text" id="siret" name="siret" value="{{old("siret")}}" class="form-control col-md-6" placeholder="Numero de SIRET">
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">
                                    Description
                                </label>
                                <textarea name="description" id="description" value="{{old("description")}}" class="form-control col-md-6" placeholder="Description de votre entreprise"></textarea>
                            </div>

                            <div class="form-group row border border-success">
                                <div id="adresses">
                                    <input type="hidden" name="nbAdresse" id="compteur">
                                    <label class="mb-3 mt-3 ml-5">Adresse(s)</label>

                                    <div id="block_adresse_0" class="form-group ml-1">
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" id="adresse_0_rue" name="adresse_0_rue" placeholder="Rue">
                                                <input type="text" id="adresse_0_ville" name="adresse_0_ville" placeholder="Ville">
                                                <input type="text" id="adresse_0_codePostal" name="adresse_0_codePostal" placeholder="Code Postal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="button" id="add-adresse" class="btn btn-primary">Ajouter une adresse</button>
                            </div>

                            <div class="form-group border border-success">
                                <label class="mb-3 mt-3 ml-5">Contacts</label>
                                <div id="contacts" class="row">
                                    <input type="hidden" name="nbContact" id="compteurContact">
                                </div>
                                <div id="contactsExist">
                                    <input type="hidden" name="nbContactExist" id="compteurContactExist">
                                </div>
                            </div>


                            <div class="form-group">
                                <button type="button" id="add-contact" class="btn btn-primary">Ajouter un contact</button>
                                <button type="button" id="add-contactExist" class="btn btn-primary">Ajouter un contact déjà inscrit</button>
                            </div>



                            <div class="col-md-8 offset-md-4">
                                <button class="btn btn-success" type="submit">Ajouter mon entreprise</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javaScript')
    <script>
        let boutonAddContact = document.getElementById('add-contact');

        let boutonAddContactExist = document.getElementById('add-contactExist');

        let boutonAddAdresse = document.getElementById('add-adresse');

        boutonAddContact.addEventListener('click',addContact);

        boutonAddContactExist.addEventListener('click',addContactExist);


        boutonAddAdresse.addEventListener('click' , addAdresse);
        function addAdresse () {

            let divAdresses = document.getElementById('adresses');
            let index = parseInt(divAdresses.childNodes.length)-6;

            let divFormGroup = document.createElement("div");
            divFormGroup.setAttribute("class", "form-group ml-1");
            divFormGroup.setAttribute("id", "block_adresse_"+index);

            let divRow = document.createElement("div");
            divRow.setAttribute("class", "row");

            let divCol11 = document.createElement("div");
            divCol11.setAttribute("class", 'col-11');

            let divCol1 = document.createElement("div");
            divCol1.setAttribute("class", "col-1");

            let inputRue = document.createElement("input");
            inputRue.setAttribute("id","adresse_"+index+"_rue");
            inputRue.setAttribute("name","adresse_"+index+"_rue");
            inputRue.setAttribute("type", "text");
            inputRue.setAttribute("placeholder", "Rue");

            let inputVille = document.createElement("input");
            inputVille.setAttribute("id","adresse_"+index+"_ville");
            inputVille.setAttribute("name","adresse_"+index+"_ville");
            inputVille.setAttribute("type", "text");
            inputVille.setAttribute("placeholder", "Ville");

            let inputCodePostale = document.createElement("input");
            inputCodePostale.setAttribute("id","adresse_"+index+"_codePostal");
            inputCodePostale.setAttribute("name","adresse_"+index+"_codePostal");
            inputCodePostale.setAttribute("type", "text");
            inputCodePostale.setAttribute("placeholder", "Code Postal");

            let inputDelete = document.createElement("button");
            inputDelete.setAttribute("id", "delete_"+index);
            inputDelete.setAttribute("class", "btn btn-danger");
            inputDelete.setAttribute("data-action", "delete");
            inputDelete.setAttribute("data-target", "block_adresse_"+index);
            inputDelete.setAttribute("type", "button");

            let X = document.createTextNode("X");
            inputDelete.appendChild(X);

            divCol1.appendChild(inputDelete);
            divCol11.appendChild(inputRue);
            divCol11.appendChild(inputVille);
            divCol11.appendChild(inputCodePostale);

            divRow.appendChild(divCol11);
            divRow.appendChild(divCol1);

            divFormGroup.appendChild(divRow);

            divAdresses.appendChild(divFormGroup);

            let bouton = document.getElementById('delete_'+index);
            bouton.addEventListener('click', supprimerAdresse);

            document.getElementById("compteur").value = index+1;
        }

        function supprimerAdresse(){
            let inputCompteur = document.getElementById("compteur");
            let compteur = parseInt(inputCompteur.value)-1;
            let target = this.dataset.target;
            let divSupprimer = document.getElementById(target);

            let id = parseInt(target.substr(14,1));

            document.getElementById("adresses").removeChild(divSupprimer);

            for(let i = id; i < compteur; i++){
                let div =document.getElementById("block_adresse_"+(i+1));
                div.setAttribute('id', "block_adresse_"+i);

                let inputRue = document.getElementById("adresse_"+(i+1)+"_rue");
                let inputVille = document.getElementById("adresse_"+(i+1)+"_ville");
                let inputCodePostal = document.getElementById("adresse_"+(i+1)+"_codePostal");
                let inputDelete = document.getElementById("delete_"+(i+1));

                inputRue.setAttribute('name', "adresse_"+i+"_rue");
                inputRue.setAttribute('id', "adresse_"+i+"_rue");

                inputVille.setAttribute('name', "adresse_"+i+"_ville");
                inputVille.setAttribute('id', "adresse_"+i+"_ville");

                inputCodePostal.setAttribute('name', "adresse_"+i+"_codePostal");
                inputCodePostal.setAttribute('id', "adresse_"+i+"_codePostal");

                inputDelete.setAttribute('data-target', "block_adresse_"+i);
                inputDelete.setAttribute('id', "delete_"+i);
            }

            inputCompteur.value -=1;
        }


        function addContactExist() {

            let divContact = document.getElementById('contactsExist');

            let index = parseInt(divContact.childNodes.length)-3;

            let divFormGroup = document.createElement("div");
            divFormGroup.setAttribute("class", "form-group ml-1");
            divFormGroup.setAttribute("id", "block_contact_exist_"+index);

            let divRow = document.createElement("div");
            divRow.setAttribute("class", "row");

            let divCol11 = document.createElement("div");
            divCol11.setAttribute("class", 'col-10');

            let divCol1 = document.createElement("div");
            divCol1.setAttribute("class", "col-1");

            let inputSelect = document.createElement("select");
            inputSelect.setAttribute("id", 'contact_'+index);
            inputSelect.setAttribute('class','form-control');
            inputSelect.setAttribute('name','contact_'+index);



            inputSelect.innerHTML+="@foreach($contacts as $contact)<option value='{{$contact->id}}'>{{$contact->nom}} {{$contact->prenom}}</option>@endforeach";

            divCol11.appendChild(inputSelect);


            //######################### Bouton supression ##################

            let inputDelete = document.createElement("button");
            inputDelete.setAttribute("id", "contact_exist_delete_"+index);
            inputDelete.setAttribute("class", "btn btn-danger");
            inputDelete.setAttribute("data-action", "delete");
            inputDelete.setAttribute("data-target", "block_contact_exist_"+index);
            inputDelete.setAttribute("type", "button");

            let X = document.createTextNode("X");
            inputDelete.appendChild(X);

            divCol1.appendChild(inputDelete);

            divRow.appendChild(divCol11);
            divRow.appendChild(divCol1);

            divFormGroup.appendChild(divRow);

            divContact.appendChild(divFormGroup);


            document.getElementById("compteurContactExist").value = index+1;

            let bouton = document.getElementById('contact_exist_delete_'+index);
            bouton.addEventListener('click', supprimerContactExist);
        }

        function supprimerContactExist(){
            let inputCompteur = document.getElementById("compteurContactExist");
            let compteur = parseInt(inputCompteur.value)-1;

            let target = this.dataset.target;
            let divSupprimer = document.getElementById(target);

            let id = parseInt(target.substr(20));
            document.getElementById("contactsExist").removeChild(divSupprimer);

            for(let i = id; i < compteur; i++){
                let div =document.getElementById("block_contact_exist"+(i+1));
                div.setAttribute('id', "block_contact_exist"+i);

            }
            inputCompteur.value -=1;
        }

        function addContact() {
            let divContact = document.getElementById('contacts');

            let index = parseInt(divContact.childNodes.length)-3;

            let divFormGroup = document.createElement("div");
            divFormGroup.setAttribute("class", "form-group ml-2 col-10");
            divFormGroup.setAttribute("id", "block_contact_"+index);

            let divRow = document.createElement("div");
            divRow.setAttribute("class", "row");

            let divCol11 = document.createElement("div");
            divCol11.setAttribute("class", 'col-11');

            let divCol1 = document.createElement("div");
            divCol1.setAttribute("class", "col-1");


            //#################################     Civilité  ###########################


            let divFormCivilite = document.createElement("div");
            divFormCivilite.setAttribute("class", "form-group row");

            let labelCivilite = document.createElement("label");
            labelCivilite.setAttribute("class", "col-md-4 col-form-label text-md-right");
            labelCivilite.setAttribute("for","civilite");
            let textLabelCivilite = document.createTextNode("Civilité");

            labelCivilite.appendChild(textLabelCivilite);

            let divCol5Civilite = document.createElement("div");
            divCol5Civilite.setAttribute("class", "col-md-5");
            let inputCivilite = document.createElement("select");
            inputCivilite.setAttribute("id", "contact_"+index+"_civilite");
            inputCivilite.setAttribute("class", "form-control");
            inputCivilite.setAttribute("name", "contact_"+index+"_civilite");

            let optionMonsieur = document.createElement("option");
            optionMonsieur.appendChild(document.createTextNode("Monsieur"));
            let optionMadame = document.createElement("option");
            optionMadame.appendChild(document.createTextNode("Madame"));
            let optionAutre = document.createElement("option");
            optionAutre.appendChild(document.createTextNode("Autre"));

            inputCivilite.appendChild(optionMonsieur);
            inputCivilite.appendChild(optionMadame);
            inputCivilite.appendChild(optionAutre);

            divCol5Civilite.appendChild(inputCivilite);

            divFormCivilite.appendChild(labelCivilite);
            divFormCivilite.appendChild(divCol5Civilite);

            divCol11.appendChild(divFormCivilite);



            //#################################     NOM  ###########################


            let divFormNom = document.createElement("div");
            divFormNom.setAttribute("class", "form-group row");

            let labelNom = document.createElement("label");
            labelNom.setAttribute("class", "col-md-4 col-form-label text-md-right");
            labelNom.setAttribute("for","nom");
            let textLabelNom = document.createTextNode("Nom");
            labelNom.appendChild(textLabelNom);

            let divCol5Nom = document.createElement("div");
            divCol5Nom.setAttribute("class", "col-md-5");
            let inputNom = document.createElement("input");
            inputNom.setAttribute("id", "contact_"+index+"_nom");
            inputNom.setAttribute("class", "form-control");
            inputNom.setAttribute("type","text");
            inputNom.setAttribute("name", "contact_"+index+"_nom");

            divCol5Nom.appendChild(inputNom);

            divFormNom.appendChild(labelNom);
            divFormNom.appendChild(divCol5Nom);

            divCol11.appendChild(divFormNom);


            //#################################     Prenom  ###########################

            let divFormPrenom = document.createElement("div");
            divFormPrenom.setAttribute("class", "form-group row");

            let labelPrenom = document.createElement("label");
            labelPrenom.setAttribute("class", "col-md-4 col-form-label text-md-right");
            labelPrenom.setAttribute("for","prenom");
            let textLabelPrenom = document.createTextNode("Prénom");
            labelPrenom.appendChild(textLabelPrenom);

            let divCol5Prenom = document.createElement("div");
            divCol5Prenom.setAttribute("class", "col-md-5");
            let inputPrenom = document.createElement("input");
            inputPrenom.setAttribute("id", "contact_"+index+"_prenom");
            inputPrenom.setAttribute("class", "form-control");
            inputPrenom.setAttribute("type","text");
            inputPrenom.setAttribute("name", "contact_"+index+"_prenom");

            divCol5Prenom.appendChild(inputPrenom);

            divFormPrenom.appendChild(labelPrenom);
            divFormPrenom.appendChild(divCol5Prenom);

            divCol11.appendChild(divFormPrenom);




            //#################################     Mail  ###########################

            let divFormMail = document.createElement("div");
            divFormMail.setAttribute("class", "form-group row");

            let labelMail = document.createElement("label");
            labelMail.setAttribute("class", "col-md-4 col-form-label text-md-right");
            labelMail.setAttribute("for","mail");
            let textLabelMail = document.createTextNode("Mail");
            labelMail.appendChild(textLabelMail);

            let divCol5Mail = document.createElement("div");
            divCol5Mail.setAttribute("class", "col-md-5");
            let inputMail = document.createElement("input");
            inputMail.setAttribute("id", "contact_"+index+"_mail");
            inputMail.setAttribute("class", "form-control");
            inputMail.setAttribute("type","text");
            inputMail.setAttribute("name", "contact_"+index+"_mail");

            divCol5Mail.appendChild(inputMail);

            divFormMail.appendChild(labelMail);
            divFormMail.appendChild(divCol5Mail);

            divCol11.appendChild(divFormMail);



            //#################################     Telephone  ###########################

            let divFormPhone = document.createElement("div");
            divFormPhone.setAttribute("class", "form-group row");

            let labelPhone = document.createElement("label");
            labelPhone.setAttribute("class", "col-md-4 col-form-label text-md-right");
            labelPhone.setAttribute("for","nom");
            let textLabelPhone = document.createTextNode("Téléphone");
            labelPhone.appendChild(textLabelPhone);

            let divCol5Phone = document.createElement("div");
            divCol5Phone.setAttribute("class", "col-md-5");
            let inputPhone = document.createElement("input");
            inputPhone.setAttribute("id", "contact_"+index+"_phone");
            inputPhone.setAttribute("class", "form-control");
            inputPhone.setAttribute("type","text");
            inputPhone.setAttribute("name", "contact_"+index+"_phone");

            divCol5Phone.appendChild(inputPhone);

            divFormPhone.appendChild(labelPhone);
            divFormPhone.appendChild(divCol5Phone);

            divCol11.appendChild(divFormPhone);

            //######################### Role dans l'entreprise #####################

            let divFormRole = document.createElement("div");
            divFormRole.setAttribute("class", "form-group row");

            let labelRole = document.createElement("label");
            labelRole.setAttribute("class", "col-md-4 col-form-label text-md-right");
            labelRole.setAttribute("for","role");
            let textLabelRole = document.createTextNode("Rôle dans l'entreprise");
            labelRole.appendChild(textLabelRole);

            let divCol5Role = document.createElement("div");
            divCol5Role.setAttribute("class", "col-md-5");
            let inputRole = document.createElement("input");
            inputRole.setAttribute("id", "contact_"+index+"_role");
            inputRole.setAttribute("class", "form-control");
            inputRole.setAttribute("type","text");
            inputRole.setAttribute("name", "contact_"+index+"_role");

            divCol5Role.appendChild(inputRole);

            divFormRole.appendChild(labelRole);
            divFormRole.appendChild(divCol5Role);

            divCol11.appendChild(divFormRole);



            //######################### Bouton supression ##################

            let inputDelete = document.createElement("button");
            inputDelete.setAttribute("id", "contact_delete_"+index);
            inputDelete.setAttribute("class", "btn btn-danger");
            inputDelete.setAttribute("data-action", "delete");
            inputDelete.setAttribute("data-target", "block_contact_"+index);
            inputDelete.setAttribute("type", "button");

            let X = document.createTextNode("X");
            inputDelete.appendChild(X);

            divCol1.appendChild(inputDelete);


            //######################### mise en page #######################

            divRow.appendChild(divCol11);
            divRow.appendChild(divCol1);

            divFormGroup.appendChild(divRow);

            divContact.appendChild(divFormGroup);

            document.getElementById("compteurContact").value = index+1;

            let bouton = document.getElementById('contact_delete_'+index);
            bouton.addEventListener('click', supprimerContact);
        }





        function supprimerContact(){
            let inputCompteur = document.getElementById("compteurContact");
            let compteur = parseInt(inputCompteur.value)-1;

            let target = this.dataset.target;
            let divSupprimer = document.getElementById(target);

            let id = parseInt(target.substr(14));
            document.getElementById("contacts").removeChild(divSupprimer);

            for(let i = id; i < compteur; i++){
                let div =document.getElementById("block_contact_"+(i+1));
                div.setAttribute('id', "block_contact_"+i);

                let inputCivilite = document.getElementById("contact_"+(i+1)+"_civilite")
                let inputNom = document.getElementById("contact_"+(i+1)+"_nom");
                let inputPrenom = document.getElementById("contact_"+(i+1)+"_prenom");
                let inputMail = document.getElementById("contact_"+(i+1)+"_mail");
                let inputPhone = document.getElementById("contact_"+(i+1)+"_phone");
                let inputDelet = document.getElementById("contact_delete_"+(i+1));

                inputCivilite.setAttribute('name', "contact_"+i+"_civilite");
                inputCivilite.setAttribute('id', "contact_"+i+"_civilite");

                inputNom.setAttribute('name', "contact_"+i+"_nom");
                inputNom.setAttribute('id', "contact_"+i+"_nom");

                inputPrenom.setAttribute('name', "contact_"+i+"_prenom");
                inputPrenom.setAttribute('id', "contact_"+i+"_prenom");

                inputMail.setAttribute('name', "contact_"+i+"_mail");
                inputMail.setAttribute('id', "contact_"+i+"_mail");

                inputPhone.setAttribute('name', "contact_"+i+"_phone");
                inputPhone.setAttribute('id', "contact_"+i+"_phone");

                inputDelet.setAttribute('data-target', "block_contact_"+i);
                inputDelet.setAttribute('id', "contact_delete_"+i);



            }
            inputCompteur.value -=1;
        }


        document.getElementById("compteur").value = 1;
        document.getElementById("compteurContact").value = 0;

    </script>
@endsection
