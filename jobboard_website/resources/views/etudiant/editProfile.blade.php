@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <form>
        <fieldset>
            <legend>Compétences</legend>
            <div class="form-group">
                <input type="text" class="form-control" id="competence" aria-describedby="infoComp" placeholder="Exemple: Javascript">
                <small id="infoComp" class="form-text text-muted">Vos compétences seront visibles sur votre profile</small><br>
                <button type="button" class="btn btn-primary">Ajouter</button>
            </div>
        </fieldset>
    </form>
    <form>
        <fieldset>
            <legend>Expériences</legend>
            <div class="form-group">
                <input type="text" class="form-control" id="intitulePoste" placeholder="Exemple: développeur web">
                Date de début<input type="date" class="form-control" id="dateDebut">
                Date de fin<input type="date" class="form-control" id="dateFin">
                <label for="description">Description du poste</label>
                <textarea class="form-control" id="description" rows="3" style="height: 30px;"></textarea><br>
                <button type="button" class="btn btn-primary">Ajouter</button>
            </div>
        </fieldset>
    </form>
    <form>
        <fieldset>
            <legend>Centres d'intérêt</legend>
            <div class="form-group">
                <input type="text" class="form-control" id="intitulePoste" placeholder="Exemple: Visionner des vidéos d'El Pueblo"><br>
                <button type="button" class="btn btn-primary">Ajouter</button>
            </div>
        </fieldset>
    </form>


@endsection