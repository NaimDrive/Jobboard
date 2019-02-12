<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="{{route('accueil')}}">JobBoard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('accueil') }}">Accueil<!-- <span class="sr-only">(current)</span>--></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Offres</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                @else
                    <li class="nav-item"><a href="{{route('logout')}}" class="nav-link" onclick="event.preventDefault();
document.getElementById('logout-form').submit()">Déconnexion</a></li>
                    <form action="{{route('logout')}}" method="post" style="display: none;" id="logout-form">@csrf</form>
                @endguest
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</header>