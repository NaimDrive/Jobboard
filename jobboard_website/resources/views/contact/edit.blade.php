@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        @if ($errors->any())
            <div class="alert alert-danger"  style="margin-top: 2rem">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div id="card-header" class="card-header">Modifier mon profil</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('storeContactChange') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <input type="hidden" name="idUser" value="{{ $contact->user->id }}">

                            <div class="form-group row">
                                <label for="civilite" class="col-md-4 col-form-label text-md-right">Civilité</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="civilite" name="civilite">
                                        <option value="Monsieur" {{$contact->civilite == "Monsieur" ? 'selected' : ''}}>Monsieur</option>
                                        <option value="Madame" {{$contact->civilite == "Madame" ? 'selected' : ''}}>Madame</option>
                                        <option value="Autre" {{$contact->civilite == "Autre" ? 'selected' : ''}}>Autre</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nom" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                                <div class="col-md-6">
                                    <input id="nom" type="text" class="form-control{{ $errors->has('nom') ? ' is-invalid' : '' }}" name="nom" value="{{ $contact->nom }}" required>

                                    @if ($errors->has('nom'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nom') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="prenom" class="col-md-4 col-form-label text-md-right">{{ __('Prenom') }}</label>

                                <div class="col-md-6">
                                    <input id="prenom" type="text" class="form-control{{ $errors->has('prenom') ? ' is-invalid' : '' }}" name="prenom" value="{{ $contact->prenom }}" required>

                                    @if ($errors->has('prenom'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('prenom') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Adresse E-mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $contact->mail }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="photo" class="col-md-4 col-form-label text-md-right">Image de profil</label>

                                <div class="col-md-6">
                                    <input type="file" name="photo" id="photo" value="{{ asset($contact->user->picture) }}">
                                </div>
                            </div>

                            <div id="divEntreprise">
                                <div class="form-group row">
                                    <label for="role" class="col-md-4 col-form-label text-md-right">Role dans l'entreprise *</label>

                                    <div class="col-md-6">
                                        <input id="role" type="text" class="form-control" name="role" value="{{ $contact->role }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="telephone" class="col-md-4 col-form-label text-md-right">Numéro de téléphone</label>

                                    <div class="col-md-6">
                                        <input id="telephone" type="text" class="form-control" name="telephone" value="{{$contact->telephone}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="entreprise" class="col-md-4 col-form-label text-md-right">Mon entreprise</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="entreprise" name="entreprise">
                                        <option value="null">Je n'ai pas d'entreprise</option>
                                        @foreach($entreprises as $entreprise)
                                            <option value="{{ $entreprise->id }}" {{ $contact->idEntreprise == $entreprise->id ? 'selected' : '' }}> {{ $entreprise->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <legend>Mon profil doit être visible ?</legend>
                            <div class="form-group">
                                <div class="custom-control custom-radio offset-sm-1">
                                    <input type="radio" id="actif1" name="actif" class="custom-control-input" value="1" {{$contact->actif ? "checked" : ""}}>
                                    <label class="custom-control-label" for="actif1">Oui</label>
                                </div>
                                <div class="custom-control custom-radio offset-sm-1">
                                    <input type="radio" id="actif0" name="actif" class="custom-control-input" value="0" {{$contact->actif ? "" : "checked"}}>
                                    <label class="custom-control-label" for="actif0">Non</label>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Modifier mon profil') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

