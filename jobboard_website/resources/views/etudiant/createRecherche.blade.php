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
                
            </div>
            </fieldset>
    </form>
    </div>
    </div>
    </div>

    @endsection