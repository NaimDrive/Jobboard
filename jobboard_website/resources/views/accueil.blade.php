@extends('layouts.master')

@section('content')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <h1 class="text-center"> Bienvenue dans le JobBoard de l'IUT de Lens!</h1>
    <p id="bienvenue"> Ce JobBoard a pour but de mettre en relation des élèves à la recherche d'un stage et des entreprises cherchant des stagiaire.<br><br>
        Si vous êtes un élève , nous vous invitons à créer un compte et à remplir le formulaire d'incription pour que les entreprises puissent connaitre vos compétences. <br> <br>
        Si vous êtes une entreprise, nous vous invitons a créer des offres aux quelles nos étudiants pourront repondre mais également a vous inscrire à nos job dating afin de venir rencontrer nos étudiants. <br>
    </p>
@endsection

