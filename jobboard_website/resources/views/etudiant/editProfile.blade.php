@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">


    <form method="post">
        <h1  id="formExperiences">Expériences</h1>
        <fieldset>
            Poste occupé :  <input type="text" name="poste"><br>
            Date de début : <input type="date" name="date"/><br>
            Date de fin : <input type="date" name="date"/><br>
            Description du poste : <input type="text" name="desc"/><br>
            Entreprise : <input type="text" name="location"/><br>
            <input type="button" name="send" value="ajouter" class="btn btn-primary"/><br>
        </fieldset>
    </form>


    <form method="post">
        <h1 id="formSkills">Compétences</h1>
        <fieldset>
        Compétence : <input type="text" name="competence"><br>
        <input type="button" name="send" value="ajouter" class="btn btn-primary"/><br>
        </fieldset>
    </form>


    <form method="post">
        <h1 id="formActivities">Centres d'intérêt</h1>
        <fieldset>
        Centre d'intérêt : <input type="text" name="interet"/>
        <input type="button" name="send" value="ajouter" class="btn btn-primary"/><br>
        </fieldset>
    </form>
@endsection
