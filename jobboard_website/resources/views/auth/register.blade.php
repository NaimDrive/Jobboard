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
                    <div id="card-header" class="card-header">Je m'inscrit en tant que <strong>professionnel</strong></div>

                    <div class="card-body">

                        <div class="row mb-3 justify-content-center">
                            <button class="btn btn-success" id="btnEntreprise">Je suis un <strong>professionnel</strong></button>
                            <button class="btn btn-success ml-2" id="btnEtu">Je suis un <strong>etudiant</strong></button>
                        </div>

                        <form method="POST" action="{{ route('storeUser') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <input name="status" id="status" type="hidden">

                            <div class="form-group row">
                                <label for="civilite" class="col-md-4 col-form-label text-md-right">Civilité *</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="civilite" name="civilite" value="{{old("civilite")}}" >
                                        <option value="Monsieur">Monsieur</option>
                                        <option value="Madame">Madame</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nom" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }} *</label>

                                <div class="col-md-6">
                                    <input id="nom" type="text" class="form-control{{ $errors->has('nom') ? ' is-invalid' : '' }}" name="nom" value="{{ old('nom') }}" required autofocus>

                                    @if ($errors->has('nom'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nom') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="prenom" class="col-md-4 col-form-label text-md-right">{{ __('Prenom') }} *</label>

                                <div class="col-md-6">
                                    <input id="prenom" type="text" class="form-control{{ $errors->has('prenom') ? ' is-invalid' : '' }}" name="prenom" value="{{ old('prenom') }}" required>

                                    @if ($errors->has('prenom'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('prenom') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Adresse E-mail') }} *</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }} *</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmation du mot de passe') }} *</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="photo" class="col-md-4 col-form-label text-md-right">Image de profile</label>

                                <div class="col-md-6">
                                    <input type="file" name="photo" id="photo">
                                </div>
                            </div>

                            <div id="divEntreprise">
                                <div class="form-group row">
                                    <label for="role" class="col-md-4 col-form-label text-md-right">Role dans l'entreprise *</label>

                                    <div class="col-md-6">
                                        <input id="role" type="text" class="form-control" name="role">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="telephone" class="col-md-4 col-form-label text-md-right">Numéro de téléphone</label>

                                    <div class="col-md-6">
                                        <input id="telephone" type="text" class="form-control" name="telephone">
                                    </div>
                                </div>
                            </div>

                            <div id="divEtu">
                                <div class="form-group row">
                                    <label for="dateNaissance" class="col-md-4 col-form-label text-md-right">Date de naissance *</label>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" value="{{old("dateNaissance")}}" >
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="adressePostale" class="col-md-4 col-form-label text-md-right">Adresse postale *</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="adresse" name="adresse" value="{{old("adresse")}}" placeholder="Votre adresse" ><br>
                                        <input type="text" class="form-control" id="ville" name="ville" value="{{old("ville")}}" placeholder="Votre ville" ><br>
                                        <input type="text" class="form-control" id="codepostal" name="codepostal" value="{{old("codepostal")}}" placeholder="Votre code postal" ><br>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="etudes" class="col-md-4 col-form-label text-md-right">Mes études</label>
                                    <div class="col-md-6">
                                        <select name="etudes" id="etudes">
                                            <option value="DUT">DUT</option>
                                            <option value="License Pro">License Pro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <sub>* : champs obligatoires</sub>

                            <div class="form-group row mb-0">
                                <div class="offset-md-4">
                                    <button type="submit" class="btn btn-success mt-2">
                                        {{ __('M\'inscrire') }}
                                    </button>
                                </div>

                                <a href="{{ route('linkedinConnect') }}" class="offset-md-1 col-md-1"><img class="co_linkedin" src="{{ asset("images/boutonCoLinkedin.png") }}"> </a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javaScript')
    <script>
        const cardHeader = document.getElementById("card-header");

        const divEntreprise = document.getElementById('divEntreprise');
        const divEtu = document.getElementById('divEtu');

        const btnEntreprise = document.getElementById("btnEntreprise");
        const btnEtu = document.getElementById("btnEtu");

        const status = document.getElementById('status');

        status.value = "entreprise";

        divEtu.style.display = "none";


        btnEtu.addEventListener("click", setEtu);
        btnEntreprise.addEventListener("click", setEntreprise);

        btnEntreprise.disabled = true;
        
       function setEntreprise() {
           btnEtu.disabled = false;
           btnEntreprise.disabled = true;
           cardHeader.innerHTML = "Je m'inscrit en tant que <strong>professionnel</strong>";
           divEtu.style.display = "none";
           divEntreprise.style.display = "block";
           status.value = "entreprise";
        }
        
        function setEtu() {
            btnEntreprise.disabled = false;
            btnEtu.disabled = true;
            cardHeader.innerHTML = "Je m'inscrit en tant qu'<strong>étudiant</strong>";
            divEntreprise.style.display = "none";
            divEtu.style.display = "block";
            status.value = "etudiant";

        }
        
    </script>
@endsection
