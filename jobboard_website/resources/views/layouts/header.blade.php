<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">

        <a class="navbar-brand" href="{{route('accueil')}}"> <img class="logo" src="{{asset('images/jobboard_green.png')}}" alt>obBoard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('accueil') }}">Accueil<!-- <span class="sr-only">(current)</span>--></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('afficherToutesEntreprises') }}">Entreprises</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('afficherToutContacts') }}">Professionnels</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("toutlesEtudiants", ['recherche'=>0, 'etudes'=>0]) }}">Nos Etudiants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('afficherOffres') }}">Offres</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("Recherches") }}">Les recherches</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('afficherLesForums') }}">Forums</a>
                </li>

            </ul>

            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Inscription / Connexion</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdownLink" data-toggle="dropdown">
                            @if( Auth::user()->picture != null )
                                <img src="{{ asset(Auth::user()->picture) }}" class="avatar avatar-mini" alt="Avatar de {{ Auth::user()->prenom }} {{ Auth::user()->nom }}">
                            @endif
                            {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdownLink">

                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('password') }}" class="dropdown-item">Modifier mon mot de passe</a>
                                <hr>
                                <a class="dropdown-item" href="{{route('admin')}}">Tableau de bord</a>
                                <hr>
                                <a class="dropdown-item" href="{{route('afficherLesForums')}}">Forum</a>
                                <hr>
                                <a class="dropdown-item" href="{{route('afficherLesAnnonces')}}">Annonces</a>
                                <hr>
                            @endif
                            @if(Auth::user()->isEtudiant())
                                <?php $user_id= Illuminate\Support\Facades\Auth::id();
                                $idEtu = DB::table('etudiant')->where('idUser',$user_id)->value('id');?>
                                <a class="dropdown-item" href="{{ route('consult_profile',["id"=>$idEtu]) }} "> Mon Profil</a>
                                <a class="dropdown-item" href="{{ route('edit_profile',["id"=>$idEtu]) }} "> Modifier mon Profil</a>
                                <a href="{{ route('password') }}" class="dropdown-item">Modifier mon mot de passe</a>
                                <hr>
                                <a class="dropdown-item" href="{{ route('createrecherche',["id"=>$idEtu]) }}"> Créer une recherche</a>
                                <hr>
                                <a class="dropdown-item" href="{{route('offresSave',["id"=>$idEtu])}}">Mes offres sauvegardées</a>
                                <hr>
                            @endif
                            @if(Auth::user()->isContact())
                                @php($contact = DB::table('contact_entreprise')->where('idUser',Auth::id())->first())
                                <a href="{{route('afficherUnContact',['id'=>$contact->id])}}" class="dropdown-item">Mon profil</a>
                                <a class="dropdown-item" href="{{ route('editContact',["id"=>$contact->id]) }} "> Modifier mon Profil</a>
                                <a href="{{ route('password') }}" class="dropdown-item">Modifier mon mot de passe</a>
                                <hr>
                                @if($contact->idEntreprise == null)
                                    <a href="{{ route("creerEntreprise") }}" class="dropdown-item">Inscrire mon entreprise</a>
                                @else
                                    <a href="{{ route('afficherUneEntreprise',['id'=>$contact->idEntreprise]) }}" class="dropdown-item">Voir mon entreprise</a>
                                    <a href="{{ route("creerEntreprise") }}" class="dropdown-item">Inscrire une nouvelle entreprise</a>
                                    <hr>
                                    <a href="{{ route("createOffre") }}" class="dropdown-item">Ajouter une offre</a>

                                @endif
                                <hr>
                            @endif

                            <a class="dropdown-item" href="{{route('logout')}}"
                               onclick="event.preventDefault();
document.getElementById('logout-form').submit()">Déconnexion</a>
                        </div>
                    </li>
                    <form action="{{route('logout')}}" method="post" style="display: none;" id="logout-form">@csrf</form>

                @endguest
            </ul>
        </div>
    </nav>
</header>
