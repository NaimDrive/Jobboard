<?php

namespace App\Http\Controllers;


use App\ContactEntreprise;
use App\Entreprise;
use App\Etudiant;
use App\Http\Middleware\Authenticate;
use App\Offre;
use App\Stat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController
{
    public function index()
    {

        $etudiants = Etudiant::all()->sortByDesc('id')->take(8);
        $entreprises = Entreprise::all()->sortByDesc('id')->take(5);
        $contacts = ContactEntreprise::all()->sortByDesc('id')->take(8);
        $offres = Offre::all()->sortByDesc('id')->take(2);

        $stat = Stat::all();

        foreach(Auth::user()->roles as $role) {
            if ($role->typeRole == 'ADMIN') {
                return view('administrateur/admin', compact('entreprises','stat', 'etudiants', 'contacts', 'offres'));
            }
        }
        return redirect(route('accueil'));
    }

    public function adminEntreprise()
    {
        foreach(Auth::user()->roles as $role){
            if ($role->typeRole == 'ADMIN'){
                $entreprises = Entreprise::paginate(12);
                return view('administrateur/adminEntreprise', compact('entreprises'));
            }
        }
        return redirect(route('accueil'));

    }

    public function supprEntreprise($id){
        foreach(Auth::user()->roles as $role) {
            if ($role->typeRole == 'ADMIN') {
                $contacts = ContactEntreprise::all();
                foreach ($contacts as $contact) {
                    if ($contact->idEntreprise == $id && $contact->idUser == null) { //si le contact est relié à aucun utilisateur on le supprime
                        DB::delete('delete from contact_entreprise where id = ?', [$contact->id]);
                    }
                    if ($contact->idEntreprise == $id && $contact->idUser != null) { // sinon on déréférence sa valeur idEntreprise en la metttant à null
                        DB::table('contact_entreprise')->where('id', '=', $contact->id)->update(['idEntreprise' => null]);
                    }
                }
                DB::delete('delete from entreprise where id = ? ', [$id]);
                return view('administrateur/validationSuppression');
            }
        }
        return redirect(route('accueil'));

    }

    public function adminEtudiant(){
        foreach(Auth::user()->roles as $role) {
            if ($role->typeRole == 'ADMIN') {
                $etudiants = Etudiant::paginate(12);
                return view('administrateur/adminEtudiant', compact('etudiants'));
            }
        }
        return redirect(route('accueil'));
    }

    public function supprEtudiant($id){
        foreach(Auth::user()->roles as $role) {
            if ($role->typeRole == 'ADMIN') {
                $idUser = DB::table('etudiant')->where('id', '=', $id)->value('idUser');
                DB::delete('delete from etudiant where id = ?', [$id]);
                DB::delete('delete from users where id = ?', [$idUser]);
                return view('administrateur/validationSuppression');
            }
        }
        return redirect(route('accueil'));
    }

    public function adminContact(){
        foreach(Auth::user()->roles as $role) {
            if ($role->typeRole == 'ADMIN') {
                $contacts = ContactEntreprise::paginate(12);
                return view('administrateur/adminContact', compact('contacts'));
            }
        }
        return redirect(route('accueil'));
    }

    public function supprContact($id){
        foreach(Auth::user()->roles as $role) {
            if ($role->typeRole == 'ADMIN') {
                $idUser = DB::table('contact_entreprise')->where('id', '=', $id)->value('idUser');
                DB::delete('delete from contact_entreprise where id = ?', [$id]);
                DB::delete('delete from users where id = ?', [$idUser]);
                return view('administrateur/validationSuppression');
            }
        }
        return redirect(route('accueil'));
    }

    public function adminOffre(){
        foreach(Auth::user()->roles as $role) {
            if ($role->typeRole == 'ADMIN') {
                $offres = Offre::paginate(12);
                return view('administrateur/adminOffre', compact('offres'));
            }
        }
        return redirect(route('accueil'));
    }

    public function supprOffre($id){
        foreach(Auth::user()->roles as $role) {
            if ($role->typeRole == 'ADMIN') {
                DB::delete('delete from offre where id = ?', [$id]);
                return view('administrateur/validationSuppression');
            }
        }
        return redirect(route('accueil'));
    }
}
