<?php

namespace App\Http\Controllers;


use App\Entreprise;
use App\Etudiant;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AdminController
{
    public function index()
    {
        $users = User::all();
        $etudiants_id = Etudiant::query()->pluck('idUser');
        $etudiants = Etudiant::all();
        $entreprises = Entreprise::all();
        return view('administrateur/admin',compact('entreprises','etudiants','etudiants_id','users'));
    }

    public function adminEntreprise(){

        $entreprises = Entreprise::all();
        return view('administrateur/adminEntreprise',compact('entreprises'));
    }

    public function supprEntreprise($id){
        DB::delete('delete from entreprise where id = ? ',[$id]);
        return view('administrateur/suppressionEntreprise');
    }

    public function adminEtudiant(){
        $users = User::all();
        $etudiants_id = Etudiant::query()->pluck('idUser');
        $etudiants = Etudiant::all();
        return view('administrateur/adminEtudiant',compact('etudiants','etudiants_id','users'));
    }
}