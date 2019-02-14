<?php
/**
 * Created by PhpStorm.
 * User: Loane
 * Date: 11/02/2019
 * Time: 15:30
 */

namespace App\Http\Controllers;

use App\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EtudiantController extends Controller
{
    function modifierProfile($id)
    {
        $id = Etudiant::where('idUser',$id)->get();
        $categorie = DB::table('categorie')->pluck('nomCategorie');
        return view('etudiant/editProfile',["categorie"=>$categorie,"id"=>$id]);
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

        $input=$request->only(["competence","level","categorie"]);
        $etu = DB::table('etudiant')->where('idUser', $user_id)->value('id');
        $categorie = DB::table('categorie')->where('nomCategorie', $input["categorie"])->value('id');

        DB::table('competences_etudiant')->insert([
            "nomCompetence" => $input["competence"],
            "niveauEstime" => $input["level"],
            "idEtudiant" => $etu,
            "idCategorie" => $categorie,
        ]);


        return redirect(route('edit_profile'));
    }



    function gererExperience(Request $request){
        $user_id= Auth::id();

        $this->validate($request,
            [
                "intitulePoste" => "required",
                "etablissement" => "required",
                "dateDebut" => "required",
                "dateFin" => "required",
                "description" => "required",
            ]);

        $input=$request->only(["intitulePoste","etablissement","dateDebut","dateFin","description"]);
        $etu = DB::table('etudiant')->where('idUser', $user_id)->value('id');

        DB::table('experience')->insert([
            "nom" => $input["intitulePoste"],
            "dateDebut" => $input["dateDebut"],
            "dateFin" => $input["dateFin"],
            "resume" => $input["description"],
            "etablissement" => $input["etablissement"],
            "idEtudiant" => $etu,
        ]);

        return redirect(route('edit_profile'));

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

        return redirect(route('edit_profile'));

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
                
                "nomLien"=> "required",
                "lienExterne"=> "required",
            ]);

        $input=$request->only(["civilite","dateNaissance","ville","adresse","codepostal","nomLien","lienExterne"]);


        DB::table("etudiant")->insert([
            "civilite" => $input["civilite"],
            "dateDeNaissance" => $input["dateNaissance"],
            
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