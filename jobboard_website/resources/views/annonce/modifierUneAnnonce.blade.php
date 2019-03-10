@extends("layouts.master")

@section("content")

    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-6">
                <form method="POST" action="{{route('enregistrerModifAnnonce',["id"=>$annonce->id])}}">
                    {!! csrf_field() !!}
                    <h1>Modifier l'annonce</h1>
                    <fieldset>
                        <div class="form-group">
                            <label for="title">Titre</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{$annonce->title}}"><br>
                            <label for="content">Content</label>
                            <input type="text" class="form-control" id="content" name="content" value="{{$annonce->content}}"><br>
                            <label for="datePublication">Date de Publication</label>
                            <input type="date" class="form-control" id="datePublication" name="datePublication" value="{{$annonce->datePublication}}" ><br>
                            <button type="submit" class="btn btn-success btn-lg btn-block">Confirmer</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>



@endsection