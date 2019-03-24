@extends("layouts.master")
@section("content")
    <div class="container">
        <div class="card mt-4">
            <h2 class="card-header">Forum des stages du {{ date('d/m/Y',strtotime($forum->date))}}</h2>
            <div class="card-body">
                <div class="row">
                    <p class="ml-3">Le forum débutera à {{$forum->heure}}</p>
                    @if($forum->actif && $contact && !$participe)
                        <a href="{{ route('inscriptionForum',['id'=>$forum->id]) }}" class="offset-md-6 btn btn-success">J'inscris mon entreprise au forum</a>
                    @elseif($forum->actif && $contact && $participe)
                        <a href="{{ route('editInscriptionForum',['id'=>$forum->id]) }}" class="offset-md-5 btn btn-success">Modifier mon inscription</a>
                        <a href="{{ route('desinscrireForum',['id'=>$forum->id]) }}" class="ml-3 btn btn-success">Me désinscrire</a>
                    @endif
                </div>


                <p><strong>Entreprises présentes</strong></p>
                @foreach($forum->entreprises as $entreprise)
                    <div class="border p-3 mt-3">
                        <a href="{{route('afficherUneEntreprise',["id"=>$entreprise->entrepriseP->id])}}"><strong>{{$entreprise->entrepriseP->nom}}</strong></a>
                        @if($etu)
                            @php($participe = App\EtudiantParticipe::where('idEtudiant', $etu->id)->where('idEntrepriseParticipe', $entreprise->id)->first())
                            @if($etu && !$participe)
                                <a href="{{ route('inscriptionForumEtudiant', ["idEtudiant"=>$etu->id, "idEntreprise"=>$entreprise->id]) }}" class="btn btn-success float-right">Je veux voir cette entreprise</a>
                            @elseif($etu && $participe && $participe)
                                <a href="{{ route('desinscriptionForumEtudiant', ["idEtudiant"=>$etu->id, "idEntreprise"=>$entreprise->id]) }}" class="btn btn-success float-right">Je ne veux plus voir cette entreprise</a>
                            @endif
                        @endif
                        <p><strong>Contacts présents : </strong></p>
                        <ul>
                            @foreach($entreprise->contacts as $contact)
                                <li><a href="{{route('afficherUnContact',["id"=>$contact->contact->id])}}">{{ $contact->contact->prenom }} {{ $contact->contact->nom }}</a>, {{$contact->contact->role}}</li>
                            @endforeach
                        </ul>
                        @if(Auth::user()->isAdmin())
                            <hr>
                            <p><strong>Etudiants présents : </strong></p>
                            <ul>
                                @foreach($entreprise->etudiants as $etudiant)
                                    <li><a href="{{route('consult_profile',["id"=>$etudiant->etudiant->id])}}">{{$etudiant->etudiant->user->prenom}} {{$etudiant->etudiant->user->nom}}</a></li>
                                @endforeach
                                @if($entreprise->etudiants->count() == 0)
                                    <p class="alert alert-warning">Aucun etudiant ne va voir cette entreprise</p>
                                @endif
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
