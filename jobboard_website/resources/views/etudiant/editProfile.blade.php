@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-6">
                <form>
                    <fieldset>
                        <legend>Photo de profile</legend>
                        <div class="form-group">
                            <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                        </div>
                    </fieldset>
                </form>
                <form>
                    <fieldset>
                        <legend>Compétences</legend>
                        <div class="form-group">
                            <input type="text" class="form-control" id="competence" aria-describedby="infoComp" placeholder="Exemple: Javascript">
                            <small id="infoComp" class="form-text text-muted">Vos compétences seront visibles sur votre profile</small><br>
                            <button type="button" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>
                </form>
                <form>
                    <fieldset>
                        <legend>Expériences</legend>
                        <div class="form-group">
                            <input type="text" class="form-control" id="intitulePoste" placeholder="Exemple: développeur web">
                            <div class="row">
                                <div class="col-lg-6">Date de début<input type="date" class="form-control" id="dateDebut"></div>
                                <div class="col-lg-6">Date de fin<input type="date" class="form-control" id="dateFin"></div>
                            </div>
                            <label for="description">Description du poste</label>
                            <textarea class="form-control" id="description" rows="5" style="resize: none;"></textarea><br>
                            <button type="button" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>
                </form>
                <form>
                    <fieldset>
                        <legend>Centres d'intérêt</legend>
                        <div class="form-group">
                            <input type="text" class="form-control" id="intitulePoste" placeholder="Exemple: Visionner des vidéos d'El Pueblo"><br>
                            <button type="button" class="btn btn-success col-lg-2">Ajouter</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

@endsection