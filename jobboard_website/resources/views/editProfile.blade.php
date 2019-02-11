@extends('layouts.master')

@section('content')

    <h1>Expériences</h1>
    <form method="post">
        <fieldset>
            Poste <input type="text" name="poste"><br>
            Date de début <input type="date" name="date"/><br>
            Date de fin <input type="date" name="date"/><br>
            Description du poste <input type="text" name="desc"/><br>
            Entreprise <input type="text" name="location"/><br>
            <input type="button" name="send" value="ajouter" class="btn btn-primary"/><br>
        </fieldset>
    </form>

    <h1>Compétences</h1>
    <form method="post" >
        <fieldset>
        <select name="competence" id="competence">
            <!-- Ajouter un foreach qui parcours la liste des compétences existantes -->
        </select><br>
        <input type="button" name="send" value="ajouter" class="btn btn-primary"/><br>
        </fieldset>
    </form>

    <h1>Centres d'intérêt</h1>
    <form method="post" >
        <fieldset>
        Centre d'intérêt <input type="text" name="interet"/>
        <input type="button" name="send" value="ajouter" class="btn btn-primary"/><br>
        </fieldset>
    </form>
@endsection
