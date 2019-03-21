@extends("layouts.master")

@section("content")

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Annonces</h1>
                @if(Auth::check())
                    @foreach (Auth::user()->roles as $role)
                        @if($role->typeRole == "ADMIN")
                            <a href="{{route('creerUneAnnonce')}}"><button class="btn-success">Créer une annonce</button></a>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <br><div class="row" id="btnEntrepriseAdmin">
            @foreach($annonces as $annonce)
                <div class="card text-center col-12 col-md-3">
                    <div class="card-body">
                        <strong><p class="card-title text-center"> {{ date('d/m/Y',strtotime($annonce->datePublication))}} {{$annonce->title}}</p></strong>
                        <a href="{{route('afficherUneAnnonce',[$annonce->id])}}"><button class="btn-primary mb-2">Visionner</button></a><br>
                        <a href="{{route('modifierUneAnnonce',[$annonce->id])}}"> <button class="btn-secondary mb-2">Modifier</button></a><br>
                        <a href="{{route('supprimerUneAnnonce',[$annonce->id])}}"><button class="btn-danger mb-2">Supprimer</button></a><br>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
    <div class="mt-3"> {{$annonces->links()}}</div>


@endsection