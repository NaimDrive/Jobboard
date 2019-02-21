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

    function consulterProfile($id)
    {
        if (Auth::check()) {
            $userId = DB::table('etudiant')->where('id', $id)->value('idUser'); //Pour obtenir l'id d'utilisateur de l'étudiant
            $etuId = DB::table('etudiant')->where('idUser', $userId)->value('id'); //Pour obtenir l'id d'étudiant de l'étudiant
            $role = DB::table('definir')->where('idUser', Auth::id())->value('idRole'); //Pour obtenir l'id du rôle de l'utilisateur courant

            $etudiant = Etudiant::find($id);
            $liens = DB::table('reference_lien')->where('idEtudiant',$id)->get();
            $nom = DB::table('users')->where('id',$userId)->value('nom');
            $prenom = DB::table('users')->where('id',$userId)->value('prenom');
            $image = DB::table('users')->where('id',$userId)->value('picture');//on recupere l'image de profil de l'étudiant
            $categorie = DB::table('categorie')->pluck('nomCategorie'); //On recupère tout les noms de catégories de la table categorie
            $competences = DB::table('competences_etudiant')->where('idEtudiant', $id)->get();
            $niveau = DB::table('competences_etudiant')->where('idEtudiant',$id)->value('niveauEstime');
            return view('etudiant/consultProfile',['etudiant'=>$etudiant,'nom'=>$nom,'prenom'=>$prenom,'categorie'=>$categorie,'competence'=>$competences,'niveau'=>$niveau,'liens'=>$liens,'userId'=>$userId,'etuId'=>$etuId,'role'=>$role,'image'=>$image,'id'=>$id]);
        }

        return redirect(route('login'));

    }

    function modifierProfile($id)
    {
        if (Auth::check()) {
            $userId = DB::table('etudiant')->where('id', $id)->value('idUser'); //Pour obtenir l'id d'utilisateur de l'étudiant
            $etuId = DB::table('etudiant')->where('idUser', $userId)->value('id'); //Pour obtenir l'id d'étudiant de l'étudiant
            $role = DB::table('definir')->where('idUser',Auth::id())->value('idRole'); //Pour obtenir l'id du rôle de l'utilisateur courant

            if (($userId !== Auth::id()) && ($role !== 1)) { //si l'id user de l'étudiant est différent de l'id user connecté...
                return redirect(route('accueil')); //on renvoi à la page d'accueil
                //Cela permet de verifier que l'utilisateur est bien un étudiant, et qu'il essaye d'accèder à un profile existant, qui est bien le sien
            }
            $categorie = DB::table('categorie')->pluck('nomCategorie'); //On recupère tout les noms de catégories de la table categorie
            $competences = DB::table('competences_etudiant')->where('idEtudiant', $id)->get(); //on recupere les compétences de l'étudiant qui désire modifier son profile
            $activite = DB::table('centre_d_interet')->where('idEtudiant', $id)->pluck('Interet'); //on recupere les activité de l'étudiant qui désire modifier son profile
            $experiences = DB::table('experience')->where('idEtudiant', $id)->get(); //on recupere les expériences de l'étudiant qui désire modifier son profile
            $user = DB::table('users')->where('id',$userId)->first();

            return view('etudiant/editProfile', ["categorie" => $categorie, "competence" => $competences, "activite" => $activite, "experience" => $experiences,"user"=>$user,"id" =>$id]); //on retourne la vue de modification du profile de l'étudiant
        }
        return redirect(route('login'));
    }

    function enregistrerModifs(Request $request){

        //UPDATE PHOTO DE PROFIL

        $this->validate($request,
            [
                'photo' => ['nullable','image'],
                "idEtu" => "required",
            ]);

        $photo = null;
        $idUser = DB::table('etudiant')->where('id',$request["idEtu"])->value('idUser');
        $idEtu = $request["idEtu"];

        if(isset($request['photo'])){
            if ($request->hasFile('photo')) {

                $photo = $request['photo']->store('/public/images/profilPicture');
                $photo= str_replace("public","storage",$photo);
            }

            $input=$request->only(["idEtu"]);



            DB::table('users')->where('id',$idUser)->update(
                [
                    'picture' => $photo,
                ]
            );
        }

        //UPDATE IDENTITE


        $this->validate($request,
            [
                "nom" => "required",
                "prenom" => "required",
            ]);


        $input=$request->only(["nom","prenom"]);

        DB::table('users')
            ->where('id',$idUser)
            ->update(
                [
                    "nom" => $input["nom"],
                    "prenom" => $input["prenom"],
                ]
            );
/*
        //SUPPRESSION COMPETENCES


        $this->validate($request,
            [
                "competence_del" => "required",
            ]);

        $input=$request->only(["competence_del"]);
        DB::table('competences_etudiant')->where('nomCompetence', $input["competence_del"])->where('idEtudiant',$id)->delete();

*/
        //INSERTION COMPETENCES


        $this->validate($request,
            [
                "competence"=> "required",
                "level" => "required",
                "categorie" => "required",
            ]);

        if($request["competence"] !== ""){
            $input=$request->only(["competence","level","categorie"]);
            $categorie = DB::table('categorie')->where('nomCategorie', $input["categorie"])->value('id');

            DB::table('competences_etudiant')->insert([
                "nomCompetence" => $input["competence"],
                "niveauEstime" => $input["level"],
                "idEtudiant" => $idEtu,
                "idCategorie" => $categorie,
            ]);
        }

/*

        //SUPPRESSION EXPERIENCES


        $this->validate($request,
            [
                "experience_del" => "required",
            ]);

        $input=$request->only(["experience_del"]);

        DB::table('experience')->where('nom', $input["experience_del"])->where('idEtudiant',$id)->delete();
*/

        //INSERTION EXPERIENCES


        $this->validate($request,
            [
                "intitulePoste" => "required",
                "etablissement" => "required",
                "dateDebut" => "required",
                "dateFin" => "required",
                "description" => "required",
            ]);

        if(($request["intitulePoste"] !== "") && ($request["etablissement"] !== "")){
            $input=$request->only(["intitulePoste","etablissement","dateDebut","dateFin","description"]);


            DB::table('experience')->insert([
                "nom" => $input["intitulePoste"],
                "dateDebut" => $input["dateDebut"],
                "dateFin" => $input["dateFin"],
                "resume" => $input["description"],
                "etablissement" => $input["etablissement"],
                "idEtudiant" => $idEtu,
            ]);
        }

/*

        //SUPPRESSION ACTIVITES

        $this->validate($request,
            [
                "activite_del" => "required",
            ]);

        $input=$request->only(["activite_del","idEtu"]);
        DB::table('centre_d_interet')->where('Interet', $input["activite_del"])->where('idEtudiant',$id)->delete();



        //INSERTION ACTIVITES



        $this->validate($request,
            [
                "activite"=> "required",
            ]);

        $input=$request->only(["activite"]);


        DB::table('centre_d_interet')->insert([
            "Interet" => $input["activite"],
            "idEtudiant" => $id,
        ]);

*/
    return redirect(route('edit_profile',["id"=>$idEtu]));

    }







    //GESTION RECHERCHE 

    function modifierrecherche($id)
    {
     
        if (Auth::check()) {
            $userId = DB::table('etudiant')->where('id', $id)->value('idUser'); //Pour obtenir l'id d'utilisateur de l'étudiant
            $etuId = DB::table('etudiant')->where('idUser', $userId)->value('id'); //Pour obtenir l'id d'étudiant de l'étudiant
            $role = DB::table('definir')->where('idUser',Auth::id())->value('idRole'); //Pour obtenir l'id du rôle de l'utilisateur courant

            if (($userId !== Auth::id()) && ($role !== 1 )) { //si l'id user de l'étudiant est différent de l'id user connecté...
                return redirect(route('accueil')); //on renvoi à la page d'accueil
                //Cela permet de verifier que l'utilisateur est bien un étudiant, et qu'il essaye d'accèder à un profile existant, qui est bien le sien
            }
            $recherche = DB::table('recherche')->where('idEtudiant', $etuId)->get();//on recupere les recherches de l'étudiant

            return view('etudiant/createRecherche', ["recherche"=>$recherche, "id"=>$id]); //on retourne la vue de modification du profile de l'étudiant
        }
        return redirect(route('login'));
    }

    function enregistrerRechercheOffre(Request $request)
    {
 
        $this->validate($request,
                [
                    "souhait"=> "required",
                    "duree"=> "required",
                    "dateD"=> "required",
                    "dateF"=> "required",
                    "mobilité"=> "required",
                    "idEtu" => "required",
                ]);

        $input=$request->only(["souhait","duree","dateD","dateF","mobilité","idEtu"]);

            

        DB::table('recherche')->insert([
                "souhait" => $input["souhait"],
                "dureeStage" => $input["duree"],
                "dateDebut" => $input["dateD"],
                "dateFin" => $input["dateF"],
                "mobilite" => $input["mobilité"],
                "idEtudiant" => $input["idEtu"],
        ]);


        return redirect(route('createrecherche',["id"=>$input["idEtu"]]));
   
        }

        function supprimerRecherche(Request $request){
    
            $this->validate($request,
                [
                    "recherche_del" => "required",
                    "idEtu" =>"required",
                ]);
    
            $input=$request->only(["recherche_del","idEtu"]);

            DB::table('recherche')->where('id', $input["recherche_del"])->where('idEtudiant',$input["idEtu"])->delete();

            return redirect(route('createrecherche',["id"=>$input["idEtu"]]));
        }

        function AfficheOffre(Request $request){
            return view('/etudiant/consultOffres');
        }


}
