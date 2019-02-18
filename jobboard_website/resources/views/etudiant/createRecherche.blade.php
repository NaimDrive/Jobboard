@extends('layouts.master')

@section('content')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-6">

    <!-- DEBUT DU FORMULAIRE DE RECHERCHE -->
    


    <form method="POST" action="{{route('enregistrer_recherche')}}">
            {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
            <fieldset>
            <legend>Ce que vous voulez : </legend>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6"><input type="text" class="form-control" id="souhait" name="souhait" value="{{old("souhait")}}" placeholder="Souhait"></div>
                        <div class="col-lg-6"><input type="text" class="form-control" id="duree" name="duree" value="{{old("duree")}}" placeholder="durée du stage"></div>
                        <div class="col-lg-6">Date de début<input type="date" class="form-control" id="dateD" name="dateD" value="{{old("dateD")}}"></div>
                        <div class="col-lg-6">Date de fin<input type="date" class="form-control" id="dateF" name="dateF" value="{{old("dateF")}}"></div>
                        <div class="col-lg-6"><input type="text" class="form-control" id="mobilité" name="mobilité" value="{{old("mobilité")}}" placeholder="Mobilité"></div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-lg btn-block">Confirmer</button>

                    @if(count($recherche)!==0) <!-- On vérifie qu'il y a au moins une activite pour afficher le tableau... -->
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">duree</th>
                            <th scope="col">dateD</th>
                            <th scope="col">dateF</th>
                            <th scope="col">mobilité</th>
                            <th scope="col">Suppression</th>
                        </tr>
                        </thead>
                    @foreach($recherche as $re) <!-- On génère pour chaque activite une ligne avec le nom et un bouton de suppression -->
                        <tbody>
                        <tr>
                            <form method="POST" action="{{route('supprimer_recherche')}}">
                            {!! csrf_field() !!} <!-- toujours ajouter dans un formulaire, sinon error 419 -->
                                <th scope="row">{{$re->souhait}}</th>
                                <th >{{$re->dureeStage}}</th>
                                <th>{{$re->dateDebut}}</th>
                                <th >{{$re->dateFin}}</th>
                                <th >{{$re->mobilite}}</th>
                                <td><button type="submit" class="btn btn-danger col-lg-8" id="recherche_del" name="recherche_del" value="{{$re->souhait}}">X</button></td>
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
    </div>

    @endsection