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
                <form method="POST" action="{{route('enregistrerUneAnnonce')}}" >
                    {!! csrf_field() !!}
                    <h1>Création d'une annonce</h1>
                    <fieldset>
                        <div class="form-group">
                            <label for="title">Titre</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{old("title")}}"><br>
                            <label for="content">Contenu</label>
                            <input type="text" class="form-control" id="content" name="content" value="{{old("content")}}"><br>
                            <label for="dateForum">Date de publication</label>
                            <input type="date" class="form-control" id="datePublication" name="datePublication" value="{{old("datePublication")}}" ><br>
                            <label for="position">Position de l'annonce ?</label>
                            <select id="position" name="position">
                                @for($i = 1; $i <= $posMax+1; $i++)
                                    <option value={{$i}}> {{$i}} </option>
                                @endfor
                                <option value="null" selected> Ne pas afficher</option>
                            </select><br>
                            <br><button type="submit" class="btn btn-success btn-lg btn-block">Confirmer</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>



@endsection