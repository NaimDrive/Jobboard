<?php
/**
 * Created by PhpStorm.
 * User: Loane
 * Date: 11/02/2019
 * Time: 15:30
 */

namespace App\Http\Controllers;

use App\Etudiant;
use App\ReferenceLien;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EtudiantController extends Controller
{
    function modifierProfile()
    {
        return view('etudiant/editProfile');
    }

    function consulterProfile()
    {
        return view('etudiant/consultProfile');
    }

    function creerEtudiant(){
        if(Auth::check()){
            return view('etudiant/creerEtudiant');
        }
        return redirect(route('login'));
    }


    function gererCompetence(Request $request){
        $user_id= Auth::id();

        $this->validate($request,
            [
                "competence"=> "required",
                "level" => "required",
                "categorie" => "required",
            ]);

        $input=$request->only(["competence"]);
        $etu = DB::table('etudiant')->where('idUser', $user_id)->value('id');
        $categorie = DB::table('categorie')->where('nomCategorie', $input["categorie"])->value('id');

        DB::table('competences')->insert([
            "nomCompetence" => $input["competence"],
            "niveauEstime" => $input["niveau"],
            "idEtudiant" => $etu,
            "idCategorie" => $categorie,
        ]);

        return redirect(route('accueil'));

    }

    function gererExperience(Request $request){
        $user_id= Auth::id();

        $this->validate($request,
            [
                "intitulePoste"=> "required",
                "dateDebut" => "required",
                "dateFin" => "required",
                "description" => "required",
            ]);

        $input=$request->only(["intitulePoste","dateDebut","dateFin","description"]);
        $etu = DB::table('etudiant')->where('idUser', $user_id)->value('id');

        DB::table('experience')->insert([
            "nom" => $input["intitulePoste"],
            "dateDebut" => $input["dateDebut"],
            "dateFin" => $input["dateFin"],
            "resume" => $input["description"],
            "etablissement" => $input["etablissement"],
            "idEtudiant" => $etu,
        ]);

        return redirect(route('accueil'));

    }

    function gererActivite(Request $request){
        $user_id= Auth::id();

        $this->validate($request,
            [
                "activite"=> "required",
            ]);

        $input=$request->only(["activite"]);
        $etu = DB::table('etudiant')->where('idUser', $user_id)->value('id');

        DB::table('centre_d_interet')->insert([
            "Interet" => $input["activite"],
            "idEtudiant" => $etu,
        ]);

        return redirect(route('accueil'));

    }


    function enregistrerEtudiant(Request $request){
 
        $user_id= Auth::id();

        $this->validate($request,
            [
                "civilite"=> "required",
                "dateNaissance"=> "required",
                "ville"=> "required",
                "adresse"=> "required",
                "codepostal"=> "required",
                "adresseMail"=> "required",
                "nomLien"=> "required",
                "lienExterne"=> "required",
            ]);

        $input=$request->only(["civilite","dateNaissance","ville","adresse","codepostal","adresseMail","nomLien","lienExterne"]);
        

        DB::table("etudiant")->insert([
            "civilite" => $input["civilite"],
            "dateDeNaissance" => $input["dateNaissance"],
            "mail" => $input["adresseMail"],
            "ville" => $input["ville"],
            "adresse" => $input["adresse"],
            "codePostal" => $input["codepostal"],
            "idUser" => $user_id
        ]);
        
        
        $etu = DB::table('etudiant')->where('idUser', $user_id)->value('id');

       

        DB::table("reference_lien")->insert([
            "nomReference" => $input["nomLien"],
            "UrlReference" => $input["lienExterne"],
            "idEtudiant" => $etu
        ]);

        return redirect(route('accueil'));
    }


    

        
    
}