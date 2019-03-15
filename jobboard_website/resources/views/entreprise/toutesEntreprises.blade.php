@extends('layouts.master')

@section('content')

    <style type="text/css">
        .center {
        }
    </style>
    <div class="container">
        <div class="card">
            <h1 class="card-header">Les entreprises</h1>
            <div class="card-body">
                @foreach($entreprises as $entreprise)
                    <div class="border p-3 mt-2">
                        <p>{{ $entreprise->nom }}</p>
                        <p>SIRET : {{ $entreprise->siret }}</p>
                        <p class="text-justify">{!! $entreprise->description !!}</p>
                        <a href="{{route("afficherUneEntreprise",["id"=>$entreprise->id])}}" class="btn btn-success">Voir l'entreprise</a>

                    </div>
                    @endforeach
            </div>
        </div>


        <div class="mt-3">
            {{ $entreprises->links() }}
        </div>
    </div>

@endsection
