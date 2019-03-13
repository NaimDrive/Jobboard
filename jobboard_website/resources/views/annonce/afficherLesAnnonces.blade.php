@extends("layouts.master")

@section("content")

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Annonces</h1>
                @if(Auth::check())
                    @foreach (Auth::user()->roles as $role)
                        @if($role->typeRole == "ADMIN")
                            <a href="{{route('creerUneAnnonce')}}"><button class="btn-success">Creer une annonce</button></a>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        @foreach($annonces as $annonce)
            <div class="row">
                @if(!Auth::check())
                    <div class="col-12 col-md-6">
                        <h3 style="font-size: 20px; margin-top: 1em;">{{ date('d/m/Y',strtotime($annonce->datePublication)) }} - {{$annonce->title}}</h3>
                    </div>
                    <div class="col-md-6 col-12" style="margin-top: 1em;">
                        <a href="{{route('afficherUneAnnonce',[$annonce->id])}}"> <button class="btn-primary">Informations</button></a>
                    </div>
                @endif
                @if(Auth::check())
                    @foreach (Auth::user()->roles as $role)
                        @if($role->typeRole == "ADMIN")
                            <div class="col-12 col-md-3">
                                <h3 style="font-size: 20px; margin-top: 1em;">{{ date('d/m/Y',strtotime($annonce->datePublication)) }} - {{$annonce->title}}</h3>
                            </div>
                            <div class="col-md-3 col-12" style="margin-top: 1em;">
                                <a href="{{route('afficherUneAnnonce',[$annonce->id])}}"> <button class="btn-primary">Informations</button></a>
                            </div>
                            <div class="col-12 col-md-3" style="margin-top: 1em;">
                                <a href="{{route('modifierUneAnnonce',[$annonce->id])}}"> <button class="btn-secondary">Modifier</button></a>
                            </div>
                            <div class="col-12 col-md-3" style="margin-top: 1em;">
                                <a href="{{route('supprimerUneAnnonce',[$annonce->id])}}"> <button class="btn-danger">Supprimer</button></a>
                            </div>
                        @endif
                    @endforeach
                @endif
                    @endforeach
            </div>


@endsection