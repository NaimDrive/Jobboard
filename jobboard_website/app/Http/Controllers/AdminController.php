<?php

namespace App\Http\Controllers;


use App\Entreprise;
use App\Etudiant;
use App\User;
use Illuminate\Support\Facades\App;

class AdminController
{
    public function index()
    {
        $entreprises = Entreprise::all();
        return view('administrateur/admin',compact('entreprises'),compact('etudiants'),compact('users'));
    }

    public function adminEntreprise(){

        $entreprises = Entreprise::all();
        return view('administrateur/adminEntreprise',compact('entreprises'));
    }
}