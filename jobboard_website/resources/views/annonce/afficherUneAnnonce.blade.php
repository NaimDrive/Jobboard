@extends("layouts.master")
@section("content")
    <div class="container">
        <div class="card mt-4">
            <h2 class="card-header">Annonce : {{$annonce->title}}</h2>
            <div class="card-body">
                <div class="row">
                    <p class="ml-3">L'annonce à était postée le {{ date('d/m/Y',strtotime($annonce->datePublication))}}</p>
                </div>


                <p><strong>Contenu de l'annonce</strong></p>
                    <div class="border p-3 mt-3">
                        {{$annonce->content}}
                    </div>
            </div>
        </div>
    </div>

@endsection
