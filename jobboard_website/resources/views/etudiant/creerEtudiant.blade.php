@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-6">
                <form method="POST" action="{{route('enregistrer_etudiant')}}">
                    {!! csrf_field() !!}
                    <h1>Création d'un profile</h1>
                    <fieldset>
                        <div class="form-group">
                            <label for="civilite">Civilité</label>
                            <select class="form-control" id="civilite">
                                <option>Monsieur</option>
                                <option>Madame</option>
                                <option>Autre</option>
                            </select>

                            <label for="dateNaissance">Date de naissance</label>
                            <input type="date" class="form-control" id="dateNaissance"/>

                            <label for="adressePostale">Adresse postale</label>
                            <input type="text" class="form-control" id="adressePostale"/>
                            <small id="infoAdresse" class="form-text text-muted">Spécifiez la ville ainsi que le code postal</small><br>

                            <label for="adresseMail">Adresse mail</label>
                            <input type="email" class="form-control" id="adresseMail" placeholder="Entrez votre email"><br>

                            <label for="lienExterne">Lien externe</label>
                            <input type="text" class="form-control" id="lienExterne">
                            <small id="infoAdresse" class="form-text text-muted">Un lien linkedin, github ...</small><br>

                            <button type="submit" class="btn btn-success btn-lg btn-block">Confirmer</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>








@endsection