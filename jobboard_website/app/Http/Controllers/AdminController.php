<?php

namespace App\Http\Controllers;


use App\ContactEntreprise;
use App\Entreprise;
use App\Etudiant;
use App\Offre;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class AdminController
{
    public function index()
    {
        $nbEtu = Etudiant::query()->count();
        $nbEnt = Entreprise::query()->count();
        $nbCont = ContactEntreprise::query()->count();
        $nbOf = Offre::query()->count();

        $etudiants = Etudiant::all()->sortByDesc('id')->take(10);
        $entreprises = Entreprise::all()->sortByDesc('id')->take(10);
        $contacts = ContactEntreprise::all()->sortByDesc('id')->take(10);
        $offres = Offre::all()->sortByDesc('id')->take(10);

        return view('administrateur/admin',compact('entreprises','etudiants','contacts', 'offres','nbEnt','nbEtu','nbCont','nbOf'));
    }

    public function adminEntreprise(){

        $entreprises = Entreprise::all();
        return view('administrateur/adminEntreprise',compact('entreprises'));
    }

    public function supprEntreprise($id){
        DB::delete('delete from entreprise where id = ? ',[$id]);
        return view('administrateur/validationSuppression');
    }

    public function adminEtudiant(){
        $etudiants = Etudiant::all();
        return view('administrateur/adminEtudiant',compact('etudiants'));
    }

    public function supprEtudiant($id){
        DB::delete('delete from etudiant where id = ?',[$id]);
        return view ('administrateur/validationSuppression');
    }

    public function adminContact(){
        $contacts = ContactEntreprise::all();
        return view('administrateur/adminContact',compact('contacts'));
    }
}