@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Déposer une offre</h1>
                    </div>
                    <div class="card-body">
                        <form method='POST' action="{{route('enregistrerOffre')}}">
                            {!! csrf_field() !!}
                            <div class="form-group row">
                                <label for="nomOffre" class="col-md-4 col-form-label text-md-right">
                                    Nom
                                </label>
                                <input type="text" id="nomOffre" name="nomOffre" value="{{old("nomOffre")}}" class="form-control col-md-6" placeholder="Nom de l'offre" required>
                            </div>

                            <div class="form-group row">
                                <label for="natureOffre" class="col-md-4 col-form-label text-md-right">
                                    Nature
                                </label>
                                <input type="text" id="natureOffre" name="natureOffre" value="{{old("natureOffre")}}" class="form-control col-md-6" placeholder="Nature de l'offre">
                            </div>

                            <div class="form-group row">
                                <label for="dateDebut" class="col-md-4 col-form-label text-md-right">
                                    Date de début
                                </label>
                                <input type="date" id="dateDebut" name="dateDebut" value="{{old("dateDebut")}}" class="form-control col-md-6" placeholder="Date de début">
                            </div>

                            <div class="form-group row">
                                <label for="dateFin" class="col-md-4 col-form-label text-md-right">
                                    Date de fin
                                </label>
                                <input type="date" id="dateFin" name="dateFin" value="{{old("dateFin")}}" class="form-control col-md-6" placeholder="Date de fin">
                            </div>

                            <div class="form-group row">
                                <label for="pre-embauche" class="col-md-4 col-form-label text-md-right">
                                    Pré-embauche
                                </label>
                                <select class="form-control col-md-6" id="pre-embauche" name="pre-embauche" value="{{old("pre-embauche")}}">
                                    <option value="indefini">Indéfini</option>
                                    <option value="oui" >Oui</option>
                                    <option value="non" >Non</option>
                                </select>
                            </div>

                            <div class="form-group row">
                                <label for="contexte" class="col-md-4 col-form-label text-md-right">
                                    Contexte
                                </label>
                                <textarea name="contexte" id="contexte" value="{{old("contexte")}}" class="form-control col-md-6" placeholder="Contexte de l'offre"></textarea>
                            </div>

                            <div class="form-group row">
                                <label for="objectif" class="col-md-4 col-form-label text-md-right">
                                    Objectif(s)
                                </label>
                                <textarea name="objectif" id="objectif" value="{{old("objectif")}}" class="form-control col-md-6" placeholder="Objectif(s) de la mission"></textarea>
                            </div>

                            <div class="col-md-8 offset-md-4">
                                <button class="btn btn-success mr-5" type="submit">Ajouter mon offre</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
