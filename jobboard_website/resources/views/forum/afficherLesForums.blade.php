@extends("layouts.master")

@section("content")

    <div class="container text-center">
        <div class="row">
            <div class="col-12">
                <h1>Forums</h1>
                @if(Auth::check())
                    @foreach (Auth::user()->roles as $role)
                        @if($role->typeRole == "ADMIN")
                            <a href="{{route('creerUnForum')}}"><button class="btn-success">Créer un forum</button></a>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        @foreach($forums as $forum)
            <div class="row">
            @if(!Auth::check())
                    <div class="col-12 col-md-6">
                        <h3 style="font-size: 20px; margin-top: 1em;">Forum du {{$forum->date}}</h3>
                    </div>
                    <div class="col-md-6 col-12" style="margin-top: 1em;">
                        <a href="{{route('afficherUnForum',[$forum->id])}}"> <button class="btn-primary">Informations</button></a>
                    </div>
                @endif
            @if(Auth::check())
                    @foreach (Auth::user()->roles as $role)
                        @if($role->typeRole == "ETUDIANT" || $role->typeRole == "CONTACT")
                <div class="col-12 col-md-6">
                    <h3 style="font-size: 20px; margin-top: 1em;">Forum du {{$forum->date}}</h3>
                </div>
                <div class="col-md-6 col-12" style="margin-top: 1em;">
                    <a href="{{route('afficherUnForum',[$forum->id])}}"> <button class="btn-primary">Informations</button></a>
                </div>
                        @endif
                    @if($role->typeRole == "ADMIN")
                        <div class="col-12 col-md-3">
                            <h3 style="font-size: 20px; margin-top: 1em;">Forum du {{ date('d/m/Y',strtotime($forum->date)) }}</h3>
                        </div>
                        <div class="col-md-3 col-12" style="margin-top: 1em;">
                            <a href="{{route('afficherUnForum',[$forum->id])}}"> <button class="btn-primary">Informations</button></a>
                        </div>
                        <div class="col-12 col-md-3" style="margin-top: 1em;">
                            <a href="{{route('modifierUnForum',[$forum->id])}}"> <button class="btn-secondary">Modifier</button></a>
                        </div>
                        <div class="col-12 col-md-3" style="margin-top: 1em;">
                            <a href="{{route('supprimerUnForum',[$forum->id])}}"> <button class="btn-danger">Supprimer</button></a>
                        </div>
                    @endif
                        @endforeach
                            @endif
            </div>
                <div class="mt-3">{{ $forums->links() }}</div>
            </div>
        @endforeach



@endsection