@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-6">


    <!-- DEBUT DU FORMULAIRE D'AJOUT DE RECHERCHE -->
    


    <form method="POST" action="{{route('enregistrer_recherche')}}">
        <input id="idEtu" name="idEtu" type="hidden" value={{$id}}>
            {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
            <fieldset>
            <legend>Ce que vous voulez : </legend>
                <div class="form-group">
                        Votre Souhait : 
                        <div><input type="text" class="form-control" id="souhait" name="souhait" value="{{old("souhait")}}" placeholder="Souhait"></div><br>
                        <div class="row">
                        <div class="col-lg-6">Date de début<input type="date" class="form-control" id="dateD" name="dateD" value="{{old("dateD")}}"></div>
                        
                        <div class="col-lg-6">Date de fin<input type="date" class="form-control" id="dateF" name="dateF" value="{{old("dateF")}}"></div>
                        </div><br>
                        Quelle est le secteur géographique de votre recherche ?
                        <div ><input type="text" class="form-control" id="secteurGeo" name="secteurGeo" value="{{old("secteurGeo")}}" placeholder="SecteurGeo"></div><br>

                         Quelle type de mobilité avez-vous ?
                        <div ><input type="text" class="form-control" id="mobilité" name="mobilité" value="{{old("mobilité")}}" placeholder="Mobilité"></div><br>
                    <br>
                    <button type="submit" class="btn btn-success btn-lg btn-block">Confirmer</button>
                </div>
            </fieldset>
    </form>

                <!-- DEBUT DU FORMULAIRE DE SUPPRESSION DE RECHERCHE -->

            @if(count($recherche)!==0) <!-- On vérifie qu'il y a au moins une activite pour afficher le tableau... -->
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">duree</th>
                        <th scope="col">dateD</th>
                        <th scope="col">dateF</th>
                        <th scope="col">secteurGeo</th>
                        <th scope="col">mobilité</th>
                        <th scope="col">Suppression</th>
                    </tr>
                    </thead>
                @foreach($recherche as $re) <!-- On génère pour chaque activite une ligne avec le nom et un bouton de suppression -->
                    <tbody>
                    <tr>
                    <?php 
                        $date1 = strtotime($re->dateDebut);
                        $date2 = strtotime ($re->dateFin);
                        $res = round(round(abs( $date2 - $date1  )/60/60/24)/7);
                    ?>
                        <form method="POST" action="{{route('supprimer_recherche')}}">
                            <input id="idEtu" name="idEtu" type="hidden" value={{$id}}>
                        {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
                            <th scope="row">{{$re->souhait}}</th>
                            <td>{{$res}}</td>
                            <td>{{$re->dateDebut}}</td>
                            <td >{{$re->dateFin}}</td>
                            <td >{{$re->secteurGeo}}</td>
                            <td >{{$re->mobilite}}</td>
                            <td><button type="submit" class="btn btn-danger col-lg-8" id="recherche_del" name="recherche_del" value="{{$re->id}}">X</button></td>
                        </form>
                    </tr>
                    </tbody>
                    @endforeach
                </table>
                <br>
                @endif
            </div>
            </fieldset>
            </form>
        </div>
    </div>
    @endsection

