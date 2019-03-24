@extends("layouts.master")

@section("content")

    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-6">
                @if ($errors->any())
                    <div class="alert alert-danger"  style="margin-top: 2rem">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                            <label for="position">Position de l'annonce ?</label>
                            <select id="position" name="position">
                                @for($i = 1; $i <= $posMax+1; $i++)
                                    @if($i == $annonce->position)
                                        <option selected value={{$i}}> {{$i}}</option>
                                    @else
                                    <option value={{$i}}> {{$i}} </option>
                                    @endif
                                @endfor
                                <option value="null"> Ne pas afficher</option>
                            </select><br>
                            <br><button type="submit" class="btn btn-success btn-lg btn-block">Confirmer</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>



@endsection