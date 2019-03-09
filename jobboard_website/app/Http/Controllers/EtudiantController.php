<?php
/**
 * Created by PhpStorm.
 * User: Loane
 * Date: 11/02/2019
 * Time: 15:30
 */

namespace App\Http\Controllers;


use App\CentreDInteret;
use App\CompetencesEtudiant;
use App\Etudiant;
use App\Experience;
use App\Formation;
use App\Recherche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EtudiantController extends Controller
{
    function consulterProfile($id)
    {
        if (Auth::check()) {

            $userId = DB::table('etudiant')->where('id', $id)->value('idUser');
            $role = DB::table('definir')->where('idUser',Auth::id())->value('idRole'); //Pour obtenir l'id du rôle de l'utilisateur courant

            if (($userId !== Auth::id()) && ($role !== 1)) { //si l'id user de l'étudiant est différent de l'id user connecté...
                return redirect(route('accueil')); //on renvoi à la page d'accueil
                //Cela permet de verifier que l'utilisateur est bien un étudiant, et qu'il essaye d'accèder à un profile existant, qui est bien le sien
            }


            $liens = DB::table('reference_lien')->where('idEtudiant',$id)->get();
            $etudiant = DB::table('etudiant')->where('id',$id)->first();
            $user = DB::table('users')->where('id',$userId)->first();
            $categories = DB::table('categorie')->pluck('nomCategorie');
            $competences = DB::table('competences_etudiant')->where('idEtudiant', $id)->get();
            $activites = DB::table('centre_d_interet')->where('idEtudiant', $id)->pluck('Interet');
            $experiences = DB::table('experience')->where('idEtudiant', $id)->get();
            $formations = DB::table('formation')->where('idEtudiant',$id)->get();
            $recherches = DB::table('recherche')->where('idEtudiant',$id)->get();
            $actif = DB::table('etudiant')->where('id',$id)->value('actif');


            return view('etudiant/consultProfile',
                [
                    'etudiant' => $etudiant, //Etudiant
                    'user' => $user, //Utilisateur
                    'categories'=>$categories, //Nom des catégories de compétences
                    'competences'=>$competences, //Compétences de l'étudiant
                    'activites'=>$activites, //activités (centres d'intéret) de l'étudiant
                    'experiences'=>$experiences, //Expériences de l'étudiant
                    'formations'=>$formations, //Formations de l'étudiant
                    'recherches'=>$recherches,
                    'actif'=>$actif, //Dire si l'étudiant est actif ou non
                    'liens'=>$liens, //Les liens externes de l'étudiant
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

            $listComp = DB::table('competences_etudiant')->pluck('nomCompetence');




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
                    "lien"=>$lien,
                    "listComp" => $listComp,
                ]); //on retourne la vue de modification du profile de l'étudiant
        }
        return redirect(route('login'));
    }

    function enregistrerModifs(Request $request){

        //VALIDATIONS

        $this->validate($request,
            [
                'photo' => ['nullable','image'],
                "idEtu" => "required",
            ]);

        $this->validate($request,
            [
                "nom" => ['required', "string", "max:255"],
                "prenom" => ['required', "string", "max:255"],
                "naissance" => ['required', "date", "before:today"],
                "civilite" => ['required', "string", "max:255"],
                "email" => ['required', "string", "max:255"],
                "adresse" => ['required', "string", "max:255"],
                "codePostal" => ['required', "numeric","digits:5"],
                "ville" => ['required', "string", "max:255"],
                "stage" => ['required'],
                "actif" => ['required'],
                "nbCompetence" => ['required'],
                "nbFormation" => ['required'],
                "nbExperience" => ['required'],
                "nbActivite" => ['required'],
                "nbLiens" => ['required'],
            ]);

        $compteurCompetence = $request["nbCompetence"]+=0;

        for($i = 0; $i < $compteurCompetence; $i++) {
            $this->validate($request,[
                "competence_".$i => ['required', "string", "max:255"],
                "categorie_".$i => ['required'],
                "level_".$i => ['required'],
            ]);
        }

        $compteurFormation = $request["nbFormation"]+=0;

        for($i = 0; $i < $compteurFormation; $i++) {
            $this->validate($request,[
                "formation_".$i => ['required', "string", "max:255"],
                "lieu_".$i => ['required', "string", "max:255"],
                "debut_".$i => ['required',"date","before:today"],
                "fin_".$i => ['required',"date","after:dateDebut_$i"],
            ]);
        }

        $compteurExperience = $request["nbExperience"]+=0;

        for($i = 0; $i < $compteurExperience; $i++) {
            $this->validate($request,[
                "experience_".$i => ['required', "string", "max:255"],
                "etablissement_".$i => ['required', "string", "max:255"],
                "dateDebut_".$i => ['required',"date","before:today"],
                "dateFin_".$i => ['required',"date","after:dateDebut_$i"], //a corriger
                "description_".$i => ['nullable', "string", "max:255"],
            ]);
        }

        $compteurActivite = $request["nbActivite"]+=0;

        for($i = 0; $i < $compteurActivite; $i++) {
            $this->validate($request,[
                "activite_".$i => ['required', "string", "max:255"],
            ]);
        }

        $compteurLien = $request["nbLiens"]+=0;

        for($i = 0; $i < $compteurLien; $i++) {
            $this->validate($request,[
                "lien_".$i => ['required', "string", "max:255"],
                "type_".$i => ['required'],
            ]);
        }


        //INSERTIONS

        $photo = null;
        $idUser = DB::table('etudiant')->where('id',$request["idEtu"])->value('idUser');
        $idEtu = $request["idEtu"];

        if(isset($request['photo'])){
            if ($request->hasFile('photo')) {

                $photo = $request['photo']->store('/public/images/profilPicture');
                $photo= str_replace("public","storage",$photo);
            }

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


        $input=$request->only(["nom","prenom","naissance","civilite","email","adresse","codePostal","ville","stage","actif"]);

        DB::table('users')
            ->where('id',$idUser)
            ->update(
                [
                    "nom" => $input["nom"],
                    "prenom" => $input["prenom"],
                    "email" => $input["email"],
                ]
            );

        DB::table('etudiant')
            ->where('id',$idEtu)
            ->update(
                [
                    "civilite" => $input["civilite"],
                    "adresse" => $input["adresse"],
                    "codePostal" => $input["codePostal"],
                    "ville" => $input["ville"],
                    "rechercheStage" => $input["stage"],
                    "DateDeNaissance" => $input["naissance"],
                    "actif" => $input["actif"],
                ]
            );

        for($i=0;$i<$compteurCompetence;$i++){
            $input=$request->only(["competence_".$i, "categorie_".$i, "level_".$i]);

            $idCateg = DB::table('categorie')->where('nomCategorie',$input[ "categorie_".$i])->first();

            DB::table('competences_etudiant')->insert([
                "nomCompetence" => $input["competence_".$i],
                "niveauEstime" => $input["level_".$i],
                "idEtudiant" => $idEtu,
                "idCategorie" => $idCateg->id,
            ]);
        }

        for($i=0;$i<$compteurFormation;$i++){
            $input=$request->only(["formation_".$i, "lieu_".$i, "debut_".$i, "fin_".$i]);

            DB::table('formation')->insert([
                "natureFormation" => $input["formation_".$i],
                "debut" => $input["debut_".$i],
                "fin" => $input["fin_".$i],
                "lieuFormation" => $input["lieu_".$i],
                "idEtudiant" => $idEtu,
            ]);
        }

        for($i=0;$i<$compteurExperience;$i++){
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

        for($i=0;$i<$compteurActivite;$i++){
            $input=$request->only(["activite_".$i]);

            DB::table('centre_d_interet')->insert([
                "Interet" => $input["activite_".$i],
                "idEtudiant" => $idEtu,
            ]);
        }

        for($i=0;$i<$compteurLien;$i++){
            $input=$request->only(["lien_".$i,"type_".$i]);

            DB::table('reference_lien')->insert([
                "nomReference" => $input["type_".$i],
                "UrlReference" => $input["lien_".$i],
                "idEtudiant" => $idEtu,
            ]);
        }

    return redirect(route('edit_profile',["id"=>$idEtu]));

    }

    //COMPETENCES
    public function autocompleteCompetence(Request $request){
        $data = CompetencesEtudiant::select("nomCompetence as name")->where("nomCompetence","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    public function autocompleteActivite(Request $request){
        $data = CentreDInteret::select("Interet as name")->where("Interet","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data);
    }
    public function autocompleteNomFormation(Request $request){
        $data = Formation::select("natureFormation as name")->where("natureFormation","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data);
    }
    public function autocompleteLieuFormation(Request $request){
        $data = Formation::select("lieuFormation as name")->where("lieuFormation","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data);
    }
    public function autocompleteNomExperience(Request $request){
        $data = Formation::select("nom as name")->where("nom","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data);
    }
    public function autocompleteLieuExperience(Request $request){
        $data = Formation::select("etablissement as name")->where("etablissement","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data);
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

        function AffichettEtu(){
            if (Auth::check()){
                $etudiants = Etudiant::where("actif",1)->paginate(10);
                return view('/etudiant/afficheEtudiant',['etudiants'=>$etudiants]);
            }
            return redirect(route('login'));
        }
        
        function listeRecherches(){
            if(Auth::check()){
                //$etudiants = Etudiant::where("actif",1)->paginate(10);
                $recherche = Recherche::paginate(10);
                return view('/etudiant/listeRecherches',/*['etudiants'=>$etudiants],*/['recherches'=>$recherche]);
            }
            return redirect(route('login'));

        }

}
