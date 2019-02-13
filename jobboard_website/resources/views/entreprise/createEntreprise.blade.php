@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Créer une entreptise</h1>
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

                            <div class="form-group row border border-success">
                                <div id="adresses">
                                    <input type="hidden" name="nbAdresse" id="compteur">
                                    <label class="mb-3 mt-3 ml-5">Adresses</label>

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
        let boutonAddAdresse = document.getElementById('add-adresse');

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
            bouton.addEventListener('click', handleDeleteButtons);

            document.getElementById("compteur").value = index+1;
        }

        function handleDeleteButtons(){
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
        document.getElementById("compteur").value = 1;
    </script>
@endsection
