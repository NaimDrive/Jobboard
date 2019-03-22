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
        return redirect(route('register'));
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
        return redirect(route('register'));
    }

    function enregistrerModifs(Request $request){

        //VALIDATIONS

        $messages = [
            "photo.image" => "Veuillez envoyer une photo au format valide. (JPEG,PNG...)",
            "nom.required" => "Veuillez saisir votre nom dans le champ indiqué.",
            "nom.string" => "Veuillez saisir un nom valide.",
            "nom.max" => "Veuillez saisir un nom de moins de 255 caractères.",
            "prenom.required" => "Veuillez saisir votre prénom dans le champ indiqué.",
            "prenom.string" => "Veuillez saisir un prénom valide.",
            "prenom.max" => "Veuillez saisir un prénom de moins de 255 caractères.",
            "naissance.required" => "Veuillez saisir une date de naissance dans le champ indiqué.",
            "naissance.date" => "Veuillez saisir une date de naissance au format valide.",
            "naissance.before" => "Veuillez saisir une date de naissance cohérente.",
            "email.required" => "Veuillez saisir votre adresse mail dans le champ indiqué.",
            "email.string" => "Veuillez saisir une adresse mail au format valide.",
            "email.max" => "Veuillez saisir une adresse mail de moins de 255 caractères.",
            "adresse.required" => "Veuillez saisir votre adresse postale dans le champ indiqué.",
            "adresse.string" => "Veuillez saisir une adresse postale valide.",
            "adresse.max" => "Veuillez saisir une adresse postale de moins de 255 caractères.",
            "codePostal.required" => "Veuillez saisir votre code postal dans le champ indiqué.",
            "codePostal.numeric" => "Veuillez saisir un numéro de code postal au format valide.",
            "codePostal.digits" => "Veuillez saisir un numéro de code postal composé de 5 chiffres.",
            "ville.required" => "Veuillez saisir le nom de votre ville dans le champ indiqué.",
            "ville.string" => "Veuillez saisir un nom de ville valide.",
            "ville.max" => "Veuillez saisir un nom de ville de moins de 255 caractères.",

        ];

        $this->validate($request,
            [
                'photo' => ['nullable','image'],
                "idEtu" => "required",
            ]);

        $this->validate($request,
            [
                'nom' => ['required', "string", "max:255"],
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
                "nbLiens" => ['required']
            ],$messages);

        $compteurCompetence = $request["nbCompetence"]+=0;

        for($i = 0; $i < $compteurCompetence; $i++) {

            $messages = [
                "competence_$i.required" => "Veuillez saisir une compétence dans le champ indiqué.",
                "competence_$i.string" => "Veuillez saisir une compétence valide.",
                "competence_$i.max" => "Veuillez saisir une compétence de moins de 255 caractères."
            ];

            $this->validate($request,[
                "competence_".$i => ['required', "string", "max:255"],
                "categorie_".$i => ['required'],
                "level_".$i => ['required'],
            ], $messages);
        }

        $compteurFormation = $request["nbFormation"]+=0;

        for($i = 0; $i < $compteurFormation; $i++) {

            $messages = [
                "formation_$i.required" => "Veuillez saisir une formation dans le champ indiqué.",
                "formation_$i.string" => "Veuillez saisir une formation valide.",
                "formation_$i.max" => "Veuillez saisir une formation de moins de 255 caractères.",
                "lieu_$i.required" => "Veuillez saisir un lieu de formation dans le champ indiqué.",
                "lieu_$i.string" => "Veuillez saisir un lieu de formation valide.",
                "lieu_$i.max" => "Veuillez saisir un lieu de formation de moins de 255 caractères.",
                "debut_$i.required" => "Veuillez saisir une date de début de formation dans le champ indiqué.",
                "debut_$i.date" => "Veuillez saisir une date de début de formation au format valide.",
                "debut_$i.before" => "Veuillez saisir une date de début de formation cohérente.",
                "fin_$i.required" => "Veuillez saisir une date de fin de formation dans le champ indiqué.",
                "fin_$i.date" => "Veuillez saisir une date de fin de formation au format valide.",
                "fin_$i.before" => "Veuillez saisir une date de fin de formation cohérente.",
            ];

            $this->validate($request,[
                "formation_".$i => ['required', "string", "max:255"],
                "lieu_".$i => ['required', "string", "max:255"],
                "debut_".$i => ['required',"date","before:today"],
                "fin_".$i => ['required',"date","after:dateDebut_$i"],
            ], $messages);
        }

        $compteurExperience = $request["nbExperience"]+=0;

        for($i = 0; $i < $compteurExperience; $i++) {

            $messages = [
                "experience_$i.required" => "Veuillez saisir une expérience dans le champ indiqué.",
                "experience_$i.string" => "Veuillez saisir une expérience valide.",
                "experience_$i.max" => "Veuillez saisir une expérience de moins de 255 caractères.",
                "etablissement_$i.required" => "Veuillez saisir un lieu d'expérience dans le champ indiqué.",
                "etablissement_$i.string" => "Veuillez saisir un lieu d'expérience valide.",
                "etablissement_$i.max" => "Veuillez saisir un lieu d'expérience de moins de 255 caractères.",
                "dateDebut_$i.required" => "Veuillez saisir une date de début d'expérience dans le champ indiqué.",
                "dateDebut_$i.date" => "Veuillez saisir une date de début d'expérience au format valide.",
                "dateDebut_$i.before" => "Veuillez saisir une date de début d'expérience cohérente.",
                "dateFin_$i.required" => "Veuillez saisir une date de fin d'expérience dans le champ indiqué.",
                "dateFin_$i.date" => "Veuillez saisir une date de fin d'expérience au format valide.",
                "dateFin_$i.before" => "Veuillez saisir une date de fin d'expérience cohérente.",
                "description_$i.string" => "Veuillez saisir une description d'expérience valide.",
                "description_$i.max" => "Veuillez saisir une description d'expérience de moins de 255 caractères."
            ];

            $this->validate($request,[
                "experience_".$i => ['required', "string", "max:255"],
                "etablissement_".$i => ['required', "string", "max:255"],
                "dateDebut_".$i => ['required',"date","before:today"],
                "dateFin_".$i => ['required',"date","after:dateDebut_$i"], //a corriger
                "description_".$i => ['nullable', "string", "max:255"],
            ], $messages);
        }

        $compteurActivite = $request["nbActivite"]+=0;

        for($i = 0; $i < $compteurActivite; $i++) {

            $messages = [
                "activite_$i.required" => "Veuillez saisir une activité dans le champ indiqué.",
                "activite_$i.string" => "Veuillez saisir une activité valide.",
                "activite_$i.max" => "Veuillez saisir une activité de moins de 255 caractères."
            ];

            $this->validate($request,[
                "activite_".$i => ['required', "string", "max:255"],
            ],$messages);
        }

        $compteurLien = $request["nbLiens"]+=0;

        for($i = 0; $i < $compteurLien; $i++) {

            $messages = [
                "lien_$i.required" => "Veuillez saisir un lien dans le champ indiqué.",
                "lien_$i.string" => "Veuillez saisir un lien valide.",
                "lien_$i.max" => "Veuillez saisir un lien de moins de 255 caractères."
            ];

            $this->validate($request,[
                "lien_".$i => ['required', "string", "max:255"],
                "type_".$i => ['required'],
            ],$messages);
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
        return redirect(route('register'));
    }

    function enregistrerRechercheOffre(Request $request)
    {
 
        $this->validate($request,
                [
                    "souhait"=> "required",
                    "dateD"=> "required",
                    "dateF"=> "required",
                    "secteurGeo"=> "required",
                    "mobilité"=> "required",
                    "idEtu" => "required",
                ]);

        $input=$request->only(["souhait","dateD","dateF","secteurGeo","mobilité","idEtu"]);

            

        DB::table('recherche')->insert([
                "souhait" => $input["souhait"],
                "dateDebut" => $input["dateD"],
                "dateFin" => $input["dateF"],
            "secteurGeo" => $input["secteurGeo"],
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

        function AffichettEtu($recherche = 0, $etudes = 0){
            if (Auth::check()){
                if ($recherche && $etudes == 0)
                    $etudiants = Etudiant::where("actif",1)->where("rechercheStage",1)->paginate(10);
                elseif ($recherche && $etudes == 1)
                    $etudiants = Etudiant::where("actif",1)->where('etudes','DUT')->where("rechercheStage",1)->paginate(10);
                elseif ($recherche && $etudes == 2)
                    $etudiants = Etudiant::where("actif",1)->where('etudes','LP')->where("rechercheStage",1)->paginate(10);
                elseif (!$recherche && $etudes == 1)
                    $etudiants = Etudiant::where("actif",1)->where('etudes','DUT')->paginate(10);
                elseif (!$recherche && $etudes == 2)
                    $etudiants = Etudiant::where("actif",1)->where('etudes','LP')->paginate(10);
                else
                    $etudiants = Etudiant::where("actif",1)->paginate(10);
                return view('/etudiant/afficheEtudiant',['etudiants'=>$etudiants, 'etudes'=>$etudes, 'recherche'=>$recherche]);
            }
            return redirect(route('register'));
        }
        
        function listeRecherches(){
            if(Auth::check()){
                //$etudiants = Etudiant::where("actif",1)->paginate(10);
                $recherche = Recherche::paginate(10);

                return view('/etudiant/listeRecherches',/*['etudiants'=>$etudiants],*/['recherches'=>$recherche]);
            }
            return redirect(route('register'));

        }

}
