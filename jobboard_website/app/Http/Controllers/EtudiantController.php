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
        $userId = DB::table('etudiant')->where('id',$id)->value('idUser'); //Pour obtenir l'id d'utilisateur de l'étudiant
        $etuId = DB::table('etudiant')->where('idUser',$id)->value('id'); //Pour obtenir l'id d'étudiant de l'étudiant

        if($userId !== Auth::id()){ //si l'id user de l'étudiant est différent de l'id user connecté...
            return redirect(route('accueil')); //on renvoi à la page d'accueil
            //Cela permet de verifier que l'utilisateur est bien un étudiant, et qu'il essaye d'accèder à un profile existant, qui est bien le sien
        }
        $categorie = DB::table('categorie')->pluck('nomCategorie'); //On recupère tout les noms de catégories de la table categorie
        $competences = DB::table('competences_etudiant')->where('idEtudiant',$etuId)->get(); //on recupere les compétences de l'étudiant qui désire modifier son profile
        return view('etudiant/editProfile',["categorie"=>$categorie, "competence"=>$competences]); //on retourne la vue de modification du profile de l'étudiant
    }


    function consulterProfile()
    {
        return view('etudiant/consultProfile');
    }



    //
    //
    //////GESTION IDENTITE
    //
    //

    function gererIdentite(Request $request){
        $user_id= Auth::id();

        $this->validate($request,
        [
            "nom" => "required",
            "prenom" => "required",
        ]);

        $input=$request->only(["nom","prenom"]);
        $userId = DB::table('etudiant')->where('idUser',$user_id)->value('idUser');
        DB::table('users')
            ->where('id',$user_id)
            ->update(
                [
                    "nom" => $input["nom"],
                    "prenom" => $input["prenom"],
                ]
            );
        return redirect(route('edit_profile',["id"=>$userId]));
    }

    //
    //
    //////GESTION COMPETENCES
    //
    //

    function supprimerCompetence(Request $request){
        $user_id= Auth::id();

        $this->validate($request,
            [
                "competence_del" => "required",
            ]);

        $input=$request->only(["competence_del"]);
        $etuId = DB::table('etudiant')->where('idUser',$user_id)->value('id');

        DB::table('competences_etudiant')->where('nomCompetence', $input["competence_del"])->where('idEtudiant',$etuId)->delete();

        return redirect(route('edit_profile',["id"=>$user_id]));
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
        $userId = DB::table('etudiant')->where('idUser',$user_id)->value('idUser');
        $categorie = DB::table('categorie')->where('nomCategorie', $input["categorie"])->value('id');

        DB::table('competences_etudiant')->insert([
            "nomCompetence" => $input["competence"],
            "niveauEstime" => $input["level"],
            "idEtudiant" => $etu,
            "idCategorie" => $categorie,
        ]);


        return redirect(route('edit_profile',["id"=>$userId]));
    }

    //
    //
    //////GESTION EXPERIENCE
    //
    //


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
        $userId = DB::table('etudiant')->where('idUser',$user_id)->value('idUser');

        DB::table('experience')->insert([
            "nom" => $input["intitulePoste"],
            "dateDebut" => $input["dateDebut"],
            "dateFin" => $input["dateFin"],
            "resume" => $input["description"],
            "etablissement" => $input["etablissement"],
            "idEtudiant" => $etu,
        ]);

        return redirect(route('edit_profile',["id"=>$userId]));

    }

    //
    //
    //////GESTION ACTIVITES
    //
    //

    function gererActivite(Request $request){
        $user_id= Auth::id();

        $this->validate($request,
            [
                "activite"=> "required",
            ]);

        $input=$request->only(["activite"]);
        $etu = DB::table('etudiant')->where('idUser', $user_id)->value('id');
        $userId = DB::table('etudiant')->where('idUser',$user_id)->value('idUser');

        DB::table('centre_d_interet')->insert([
            "Interet" => $input["activite"],
            "idEtudiant" => $etu,
        ]);

        return redirect(route('edit_profile',["id"=>$userId]));

    }


    //
    //
    //////GESTION ENREGISTREMENT ETUDIANT
    //
    //


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
