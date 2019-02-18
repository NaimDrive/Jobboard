<?php

namespace App\Http\Controllers;


use App\ContactEntreprise;
use App\Entreprise;
use App\Etudiant;
use App\Offre;
use App\User;
use Illuminate\Http\Request;
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

    public function adminEntreprise()
    {
        $entreprises = Entreprise::all();
        return view('administrateur/adminEntreprise', compact('entreprises'));
    }

    public function adminUneEntreprise($id){
        $entreprise = DB::table('entreprise')->select('*')->where('id','=',$id)->first();
        return view('administrateur/adminUneEntreprise',compact('entreprise'));
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
        $idUser = DB::table('etudiant')->where('id', '=',$id)->value('idUser');
        DB::delete('delete from etudiant where id = ?',[$id]);
        DB::delete('delete from users where id = ?',[$idUser]);
        return view ('administrateur/validationSuppression');
    }

    public function adminContact(){
        $contacts = ContactEntreprise::all();
        return view('administrateur/adminContact',compact('contacts'));
    }

    public function supprContact($id){
        $idUser = DB::table('contact_entreprise')->where('id','=',$id)->value('idUser');
        DB::delete('delete from contact_entreprise where id = ?', [$id]);
        DB::delete('delete from users where id = ?', [$idUser]);
        return view('administrateur/validationSuppression');
    }

    public function adminOffre(){
        $offres = Offre::all();
        return view('administrateur/adminOffre',compact('offres'));
    }

    public function supprOffre($id){
        DB::delete('delete from offre where id = ?',[$id]);
        return view('administrateur/validationSuppression');
    }
}