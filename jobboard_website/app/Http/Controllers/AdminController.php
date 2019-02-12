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
        $users = User::all();
        $etudiants = Etudiant::all();
        $entreprises = Entreprise::all();
        return view('administrateur/admin',compact('entreprises'),compact('etudiants'),compact('users'));
    }
}