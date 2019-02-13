@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-6">
                <form method="POST" action="{{route('enregistrer_etudiant')}}" >
                    {!! csrf_field() !!}
                    <h1>Création d'un profile</h1>
                    <fieldset>
                        <div class="form-group">
                            <label for="civilite">Civilité</label>
                            <select class="form-control" id="civilite" name="civilite" value="{{old("civilite")}}" >
                                <option>Monsieur</option>
                                <option>Madame</option>
                                <option>Autre</option>
                            </select>
                            <br>
                            <label for="dateNaissance">Date de naissance</label>
                            <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" value="{{old("dateNaissance")}}" ><br>

                            <label for="adressePostale">Adresse postale</label>
                            <input type="text" class="form-control" id="ville" name="ville" value="{{old("ville")}}" placeholder="Votre ville" ><br>
                            <input type="text" class="form-control" id="adresse" name="adresse" value="{{old("adresse")}}" placeholder="Votre adresse" ><br>
                            <input type="text" class="form-control" id="codepostal" name="codepostal" value="{{old("codepostal")}}" placeholder="Votre code postal" ><br>
                            

                            <label for="adresseMail">Adresse mail</label>
                            <input type="email" class="form-control" id="adresseMail" name="adresseMail" value="{{old("adresseMail")}}" placeholder="Entrez votre email"><br>

                            <label for="lienExterne">Lien externe</label>
                            <div class="row justify-content-md-left">
                                <div class="col-lg-3">
                                    <select class="form-control" id="nomLien" name="nomLien" value="{{old("nomLien")}}" >
                                        <option>GitHub</option>
                                        <option>Linkedin</option>
                                        <option>Autre</option>
                                    </select>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="lienExterne" name="lienExterne" value="{{old("lienExterne")}}" >
                            <small id="infoAdresse" class="form-text text-muted">Un lien linkedin, github ...</small><br>

                            <button type="submit" class="btn btn-success btn-lg btn-block">Confirmer</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>








@endsection