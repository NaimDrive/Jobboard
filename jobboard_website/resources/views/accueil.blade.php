@extends('layouts.master')

@section('content')
    <link href="{{ asset('css/accueil.css') }}" rel="stylesheet">
    <div class="container">

        <div id="slider" class="mt-5">
            <figure>
                <img src="{{asset('images/iutAutomne.jpg')}}" class="image" alt>
                <img src="{{asset('images/index.jpg')}}" class="image" alt>
                <img src="{{asset('images/IUT-de-Lens.jpg')}}" class="image" alt>


            </figure>
        </div>
        <div class="container text-justify mt-3">
            <h1> Bienvenue dans le Job Board de l'IUT de Lens </h1>
            <p> Ce JobBoard a pour but de mettre en relation des élèves à la recherche d'un stage et des entreprises cherchant des stagiaires.<br><br>
                Si vous êtes un élève, nous vous invitons à créer un compte et à remplir le formulaire d'inscription pour que les entreprises puissent connaître vos compétences. <br>
                Si vous êtes une entreprise, nous vous invitons a créer des offres auxquelles nos étudiants pourront répondre, mais également à vous inscrire à nos Job Dating afin de venir rencontrer nos étudiants. <br>
            </p>
            <div class="jumbotron" >
                <div class="border border-success">
                    <h2>L'IUT informatique de Lens forme des étudiants dans ce domaine </h2><br>

                    <h3> Le DUT : une formation complète !</h3>

                    <p> Les étudiants suivent une formation, sur deux années après le baccalauréat, qui les forme dans plusieurs domaines : </p><br>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Base de données</th>
                            <th scope="col">Programmation Web</th>
                            <th scope="col">Algorithmie</th>
                            <th scope="col">Réseau</th>
                        </tr>
                        <tbody>
                        <tr>
                            <td>MySQL</td>
                            <td>HTML / CSS</td>
                            <td>Java</td>
                            <td>Adressage IP</td>
                        </tr>
                        <tr>
                            <td>postgresql</td>
                            <td> PHP / Laravel</td>
                            <td> Python</td>
                            <td> Routage de Machine</td>
                        </tr>
                        <tr>
                            <td> sqlite </td>
                            <td> Javascript / Angular</td>
                            <td> C++</td>
                            <td>  </td>
                        </tr>
                        </tbody>
                        </thead>
                    </table>

                    <p>    Ils savent également utiliser <b>GitHub</b> , <b>Trello</b> et des IDE comme <b>Eclipse</b>, <b>IntelIj IDEA</b> ou encore <b>PhpStorm</b> ! <br> <br>

                        Mais chaque profil est unique !  Si vous êtes une entreprise qui cherche dans l'un de ces domaines, n'hésitez pas à créer une offre pour qu'ils puissent vous contacter !</p>
                    <h3> La Licence Professionnelle Métiers de l’informatique : conception, développement et test de logiciel parcours Développement Informatique et Outils Collaboratifs </h3>

                    <p>  Elle forme en un an des informaticiens polyvalents qui ont intégré dans leurs connaissances et leurs pratiques le développement informatique collaboratif et la maîtrise des frameworks sur lesquels reposent le développement des applications </p><br>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Programmation Web</th>
                            <th scope="col">Algorithmie</th>
                            <th scope="col"> Base de Données</th>
                        </tr>
                        <tbody>
                        <tr>
                            <td>PHP</td>
                            <td>Java</td>
                            <td> sqlite </td>
                        </tr>
                        <tr>
                            <td> Symfony </td>
                            <td> Python</td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td> Javascript</td>
                            <td> </td>

                        </tr>
                        </tbody>
                        </thead>
                    </table>

                    <h3> Le Stage </h3>
                    <p>
                        A la fin de leur DUT nos étudiants recherchent un stage dans le <b>développement</b> informatique. <br>
                        Il a pour but de mettre en pratique ce qu'ils ont appris durant les deux années de cours. <br>
                        Mais nos étudiants sont également avides d'apprendre de nouvelles choses et apprendront volontiers de nouveaux langages durant leur stage ! <br>
                        Leur stage doit avoir une durée minimum de dix semaines à partir du <b>8 avril 2019.</b>
                    </p>

                    <h3>     Si vous voulez rencontrer nos étudiants, c'est possible !</h3>

                    <p> Chaque année, nous organisons des <b>Job Dating</b> afin de faciliter le dialogue entre les étudiants et les entreprises.<br>
                        Si votre entreprise est intéressée, venez vous inscrire à l'un de nos Job Dating , <b>nos étudiants vous attendent !</b></p>

                    <h2>Nos forums</h2>
                    @foreach($forums as $forum)
                        <div class="m-4 border border-success p-4 row">
                            <h3>Forum des stages du {{ date('d/m/Y',strtotime($forum->date)) }}</h3>
                            <a class="ml-5 btn btn-success" href="{{ route('afficherUnForum',['id'=>$forum->id]) }}">Voir le forum</a>
                            @if($forum->actif)
                                <a class="ml-3 btn btn-success" href="{{ route('inscriptionForum',['id'=>$forum->id]) }}">Je veux m'inscrire</a>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 border border-success">
                    <h2>Annonces</h2>
                    @foreach($annonces as $annonce)
                        @if($annonce->position != -1 && $annonce->datePublication <= $dateNow)
                            <div class="border border-success p-3 m-3">
                                <h3>{{ $annonce->title }}</h3>
                                <p>Publiée le : {{ date('d/m/Y',strtotime($annonce->datePublication)) }}</p>
                                <p>{!! $annonce->content !!}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>

@endsection
