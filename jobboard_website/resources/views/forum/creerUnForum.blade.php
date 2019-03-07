@extends("layouts.master")

@section("content")

    <div class="container">
        <div class="row justify-content-md-center">
            <div class=" col-lg-6">
                <form method="POST" action="{{route('enregistrerUnForum')}}" >
                    {!! csrf_field() !!}
                    <h1>Création d'un forum</h1>
                    <fieldset>
                        <div class="form-group">
                            <label for="dateForum">Date du forum</label>
                            <input type="date" class="form-control" id="dateForum" name="dateForum" value="{{old("date")}}" ><br>
                            <label for="heureForum">Heure</label>
                            <input type="time" class="form-control" id="heureForum" name="heureForum" value="{{old("heure")}}"><br>
                            <label for="actif">Inscription possible ?</label>
                            <select class="form-control" id="actif" name="actif" value="{{old("actif")}}">
                                <option>Oui</option>
                                <option>Non</option>
                            </select>
                        <button type="submit" class="btn btn-success btn-lg btn-block">Confirmer</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>



@endsection