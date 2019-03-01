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


            return view('etudiant/consultProfile',
                [
                    'etudiant'=>$etudiant,
                    'nom'=>$nom,
                    'prenom'=>$prenom,
                    'categorie'=>$categorie,
                    'competence'=>$competences,
                    'niveau'=>$niveau,
                    'liens'=>$liens,
                    'userId'=>$userId,
                    'etuId'=>$etuId,
                    'role'=>$role,
                    'image'=>$image,
                    'id'=>$id
                ]);
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

            $etudiant = Etudiant::find($id);
            $user = DB::table('users')->where('id',$userId)->first();
            $activite = DB::table('centre_d_interet')->where('idEtudiant',$etuId)->get();
            $experience = DB::table('experience')->where('idEtudiant',$etuId)->get();
            $competence = DB::table('competences_etudiant')->where('idEtudiant',$etuId)->get();
            $formation = DB::table('formation')->where('idEtudiant', $id)->get();
            $categories = DB::table('categorie')->get();
            $lien = DB::table('reference_lien')->where('idEtudiant',$etuId)->get();



            return view('etudiant/editProfile',
                [
                    "id" =>$id,
                    "user"=>$user,
                    "etudiant"=>$etudiant,
                    "activite"=>$activite,
                    "experience"=>$experience,
                    "competence"=>$competence,
                    "categorie"=>$categories,
                    'formation'=>$formation,
                    "lien"=>$lien
                ]); //on retourne la vue de modification du profile de l'étudiant
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



            $user = DB::table('users')->where('id',$idUser)->first();
            $image = $user->picture;
            if ($image != 'images/user-icon.png'){
                $lien = public_path().'/'.$image;
                \File::delete($lien);
            }

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


        //INSERTION COMPETENCES


        $this->validate($request,
            [
                "nbCompetence"
            ]);

        DB::table('competences_etudiant')->where('idEtudiant',$idEtu)->delete();

        $compteur = $request["nbCompetence"]+=0;

        for($i = 0; $i < $compteur; $i++) {
            $this->validate($request,[
                "competence_".$i => ['required', "string", "max:255"],
                "categorie_".$i => ['required'],
                "level_".$i => ['required'],
            ]);

            $input=$request->only(["competence_".$i, "categorie_".$i, "level_".$i]);

            $idCateg = DB::table('categorie')->where('nomCategorie',$input[ "categorie_".$i])->first();

            DB::table('competences_etudiant')->insert([
                "nomCompetence" => $input["competence_".$i],
                "niveauEstime" => $input["level_".$i],
                "idEtudiant" => $idEtu,
                "idCategorie" => $idCateg->id,
            ]);

        }

        //INSERTION FORMATIONS


        $this->validate($request,
            [
                "nbFormations"
            ]);

        DB::table('formation')->where('idEtudiant',$idEtu)->delete();

        $compteur = $request["nbFormation"]+=0;

        for($i = 0; $i < $compteur; $i++) {
            $this->validate($request,[
                "formation_".$i => ['required', "string", "max:255"],
                "lieu_".$i => ['required', "string", "max:255"],
                "debut_".$i => ['required'],
                "fin_".$i => ['required'],
            ]);

            $input=$request->only(["formation_".$i, "lieu_".$i, "debut_".$i, "fin_".$i]);

            DB::table('formation')->insert([
                "natureFormation" => $input["formation_".$i],
                "debut" => $input["debut_".$i],
                "fin" => $input["fin_".$i],
                "lieuFormation" => $input["lieu_".$i],
                "idEtudiant" => $idEtu,
            ]);

        }

        //INSERTION EXPERIENCES


        $this->validate($request,
            [
                "nbExperience"
            ]);

        DB::table('experience')->where('idEtudiant',$idEtu)->delete();

        $compteur = $request["nbExperience"]+=0;

        for($i = 0; $i < $compteur; $i++) {
            $this->validate($request,[
                "experience_".$i => ['required', "string", "max:255"],
                "etablissement_".$i => ['required', "string", "max:255"],
                "dateDebut_".$i => ['required'],
                "dateFin_".$i => ['required'],
                "description_".$i => ['required', "string", "max:255"],
            ]);

            $input=$request->only(["experience_".$i, "etablissement_".$i, "dateDebut_".$i, "dateFin_".$i, "description_".$i]);

            DB::table('experience')->insert([
                "nom" => $input["experience_".$i],
                "dateDebut" => $input["dateDebut_".$i],
                "dateFin" => $input["dateFin_".$i],
                "resume" => $input["description_".$i],
                "etablissement" => $input["etablissement_".$i],
                "idEtudiant" => $idEtu,
            ]);

        }


        //INSERTION ACTIVITES


        $this->validate($request,
            [
                "nbActivite"
            ]);

        DB::table('centre_d_interet')->where('idEtudiant',$idEtu)->delete();

        $compteur = $request["nbActivite"]+=0;

        for($i = 0; $i < $compteur; $i++) {
            $this->validate($request,[
                "activite_".$i => ['required', "string", "max:255"],
            ]);

            $input=$request->only(["activite_".$i]);

            DB::table('centre_d_interet')->insert([
                "Interet" => $input["activite_".$i],
                "idEtudiant" => $idEtu,
            ]);

        }


        //INSERTION LIENS EXTERNES

        $this->validate($request,[
            "nbLiens"
        ]);

        DB::table('reference_lien')->where('idEtudiant', $idEtu)->delete();
        $compteur = $request["nbLiens"]+=0;

        for($i = 0; $i < $compteur; $i++) {
            $this->validate($request,[
                "lien_".$i => ['required', "string", "max:255"],
                "type_".$i => ['required', "string"],
            ]);

            $input=$request->only(["lien_".$i,"type_".$i]);

            DB::table('reference_lien')->insert([
                "nomReference" => $input["type_".$i],
                "UrlReference" => $input["lien_".$i],
                "idEtudiant" => $idEtu,
            ]);


        }


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

        function AffichettEtu(Request $request){
            return view('/etudiant/afficheEtudiant');
        }
    function listeRecherches(){
        return view('/etudiant/listeRecherches');

    }

}
