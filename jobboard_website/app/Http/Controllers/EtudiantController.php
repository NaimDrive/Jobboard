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
use Illuminate\Support\Facades\Storage;

class EtudiantController extends Controller
{
    function modifierProfile($id)
    {
        if (Auth::check()) {
            $userId = DB::table('etudiant')->where('id', $id)->value('idUser'); //Pour obtenir l'id d'utilisateur de l'étudiant
            $etuId = DB::table('etudiant')->where('idUser', $id)->value('id'); //Pour obtenir l'id d'étudiant de l'étudiant

            if ($userId !== Auth::id()) { //si l'id user de l'étudiant est différent de l'id user connecté...
                return redirect(route('accueil')); //on renvoi à la page d'accueil
                //Cela permet de verifier que l'utilisateur est bien un étudiant, et qu'il essaye d'accèder à un profile existant, qui est bien le sien
            }
            $categorie = DB::table('categorie')->pluck('nomCategorie'); //On recupère tout les noms de catégories de la table categorie
            $competences = DB::table('competences_etudiant')->where('idEtudiant', $etuId)->get(); //on recupere les compétences de l'étudiant qui désire modifier son profile
            $activite = DB::table('centre_d_interet')->where('idEtudiant', $etuId)->pluck('Interet'); //on recupere les activité de l'étudiant qui désire modifier son profile
            $experiences = DB::table('experience')->where('idEtudiant', $etuId)->get(); //on recupere les expériences de l'étudiant qui désire modifier son profile
            $image = DB::table('images')->where('idEtudiant',$etuId)->first(); //on recupere l'image de l'étudiant qui désire modifier son profile
            return view('etudiant/editProfile', ["categorie" => $categorie, "competence" => $competences, "activite" => $activite, "experience" => $experiences, "image" => $image]); //on retourne la vue de modification du profile de l'étudiant
        }
        return redirect(route('login'));
    }


    function consulterProfile()
    {
        return view('etudiant/consultProfile');
    }

    //
    //
    //////GESTION PHOTO DE PROFIL
    //
    //



    function gererPhoto(Request $request){
        $user_id= Auth::id();

        $this->validate($request,
            [
                "image" => "required",
                "MAX_FILE_SIZE" => "required",
            ]);

        $input = $request->only(["image","MAX_FILE_SIZE"]);
        $etuId = DB::table('etudiant')->where('idUser',$user_id)->value('id');


        if($_FILES['image']['size'] > $input['MAX_FILE_SIZE']){
            return redirect(route('edit_profile',["id"=>$user_id]));
        }

        DB::table('images')->where('idEtudiant', $etuId)->delete();

        DB::table('images')->insert([
            "name" => $_FILES['image']['name'],
            "size" => $_FILES['image']['size'],
            "type" => $_FILES['image']['type'],
            "desc" => "rien",
            "img" => file_get_contents ($_FILES['image']['tmp_name']),
            "idEtudiant" => $etuId,
        ]);

        return redirect(route('edit_profile',["id"=>$user_id]));

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

    function supprimerExperience(Request $request){
        $user_id= Auth::id();

        $this->validate($request,
            [
                "experience_del" => "required",
            ]);

        $input=$request->only(["experience_del"]);
        $etuId = DB::table('etudiant')->where('idUser',$user_id)->value('id');

        DB::table('experience')->where('nom', $input["experience_del"])->where('idEtudiant',$etuId)->delete();

        return redirect(route('edit_profile',["id"=>$user_id]));
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


    function supprimerActivite(Request $request){
        $user_id= Auth::id();

        $this->validate($request,
            [
                "activite_del" => "required",
            ]);

        $input=$request->only(["activite_del"]);
        $etuId = DB::table('etudiant')->where('idUser',$user_id)->value('id');

        DB::table('centre_d_interet')->where('Interet', $input["activite_del"])->where('idEtudiant',$etuId)->delete();

        return redirect(route('edit_profile',["id"=>$user_id]));
    }



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


    //GESTION RECHERCHE 

    function modifierrecherche($id)
    {
     
        if (Auth::check()) {
            $userId = DB::table('etudiant')->where('id', $id)->value('idUser'); //Pour obtenir l'id d'utilisateur de l'étudiant
            $etuId = DB::table('etudiant')->where('idUser', $id)->value('id'); //Pour obtenir l'id d'étudiant de l'étudiant

            if ($userId !== Auth::id()) { //si l'id user de l'étudiant est différent de l'id user connecté...
                return redirect(route('accueil')); //on renvoi à la page d'accueil
                //Cela permet de verifier que l'utilisateur est bien un étudiant, et qu'il essaye d'accèder à un profile existant, qui est bien le sien
            }
            $recherche = DB::table('recherche')->where('idEtudiant', $etuId)->get();//on recupere les recherches de l'étudiant

            return view('etudiant/createRecherche', ["recherche"=>$recherche]); //on retourne la vue de modification du profile de l'étudiant
        }
        return redirect(route('login'));
    }

    function enregistrerRechercheOffre(Request $request)
    {
        $user_id= Auth::id();
 
        $this->validate($request,
                [
                    "souhait"=> "required",
                    "duree"=> "required",
                    "dateD"=> "required",
                    "dateF"=> "required",
                    "mobilité"=> "required",
                    
                ]);

        $input=$request->only(["souhait","duree","dateD","dateF","mobilité"]);
        $etu = DB::table('etudiant')->where('idUser', $user_id)->value('id');
            

        DB::table('recherche')->insert([
                "souhait" => $input["souhait"],
                "dureeStage" => $input["duree"],
                "dateDebut" => $input["dateD"],
                "dateFin" => $input["dateF"],
                "mobilite" => $input["mobilité"],
                "idEtudiant" => $etu
        ]);


        return redirect(route('createrecherche',["id"=>$user_id]));
   
        }

        function supprimerRecherche(Request $request){
            $user_id= Auth::id();
    
            $this->validate($request,
                [
                    "recherche_del" => "required",
                ]);
    
            $input=$request->only(["recherche_del"]);
            $etuId = DB::table('etudiant')->where('idUser',$user_id)->value('id');

            DB::table('recherche')->where('id', $input["recherche_del"])->where('idEtudiant',$etuId)->delete();

            return redirect(route('createrecherche',["id"=>$user_id]));
        }


}
