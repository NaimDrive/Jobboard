<?php

namespace App\Http\Controllers;

use App\Entreprise;
use App\Etudiant;
use Illuminate\Http\Request;
use App\Offre ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OffreController extends Controller
{


    function peutCreer(){
        $peutCreer=false;
        foreach(Auth::user()->roles as $role){
            if($role->typeRole == 'CONTACT'){

                $idEntreprise = DB::table("contact_entreprise")->where("idUser",Auth::id())->value("idEntreprise");
                if($idEntreprise != null ){
                    $peutCreer = true ;
                }

            }
        }
        return $peutCreer;
    }

    function peutModifier($id){
        foreach(Auth::user()->roles as $role){
            if($role->typeRole == 'CONTACT'){

                $offreEntreprise = DB::table('offre')->where('id',$id)->value('idEntreprise');
                $idEntreprise = DB::table("contact_entreprise")->where("idUser",Auth::id())->value("idEntreprise");
                if($idEntreprise == $offreEntreprise ){
                     return true ;
                }

            }
            elseif($role->typeRole == 'ADMIN'){
                return true;
            }
        }
        return false;
    }

    function creerOffre(){
        if (Auth::check() && $this->peutCreer()){
            $idEntreprise = DB::table("contact_entreprise")->where("idUser",Auth::id())->value("idEntreprise");
            return view('offre/createOffre',["entreprise"=>Entreprise::find($idEntreprise)]);
        }
    }


    function enregistrerOffre(Request $request){
        $messages = [
            'nomOffre.required' => "Le champ nom de l'offre de peut pas être vide.",
            'nomOffre.string' => "Le champ nom de l'offre doit être une chaine de caractères.",
            'nomOffre.min' => "Le champ nom de l'offre doit être composé d'au moins 3 caractères.",
            'natureOffre.required' => "Le champ nature de l'offre de peut pas être vide.",
            'natureOffre.string' => "Le champ nature de l'offre doit être une chaine de caractères.",
            'natureOffre.min' => "Le champ nature de l'offre doit être composé d'au moins 3 caractères.",
            'dateDebut.required' => "Le champ date de début du stage ne peut pas être vide.",
            'dateDebut.date' => "Le champ date de début du stage doit être une date.",
            'dateDebut.after' => "Le stage doit débuter après la date d'aujourd'hui.",
            'dateFin.required' => "Le champ date de fin du stage ne peut pas être vide.",
            'dateFin.date' => "Le champ date de fin du stage doit être une date.",
            'dateFin.after' => "Le stage doit finir après la date de début de stage.",
            'pre-embauche.required' => "Le champ pre-embauche de peut pas être vide.",
            'pre-embauche.string' => "Le champ pre-embauche doit être une chaine de caractères.",
            'pre-embauche.min' => "Le champ pre-embauche doit être composé d'au moins 3 caractères.",
            'pre-embauche.max' => "Le champ pre-embauche doit être composé d'au plus 8 caractères.",
            'context.required' => "Le champ contexte de peut pas être vide.",
            'context.string' => "Le champ contexte doit être une chaine de caractères.",
            'context.min' => "Le champ contexte doit être composé d'au moins 10 caractères.",
            'context.max' => "Le champ contexte doit être composé d'au plus 1000 caractères.",
            'objectif.required' => "Le champ objectif de peut pas être vide.",
            'objectif.string' => "Le champ objectif doit être une chaine de caractères.",
            'objectif.min' => "Le champ objectif doit être composé d'au moins 10 caractères.",
            'objectif.max' => "Le champ objectif doit être composé d'au plus 1000 caractères.",
            'location.required' => "Le champ localisation du stage ne peut pas être vide.",
            'depot.file' => "Le format du fichier déposé n'est pas valide",
            'lienOffre.url' => "Le lien doit être un lien valide : https://www.google.com/",
        ];

        $this->validate($request,[
           "nomOffre" => ["required","string","min:3","max:255"],
            "natureOffre" => ["required","string","min:3","max:255"],
            "dateDebut" => ["required","date","after:today"],
            "dateFin" => ["required","date","after:dateDebut"],
            "pre-embauche" => ["required","string","min:3","max:8"],
            "contexte" => ["required","string","min:10","max:1000"],
            "objectif" => ["required","string",'min:10',"max:1000"],
            "location" => ["required"],
            "depot" => ["nullable","file"],
            "lienOffre" => ["nullable","url"]
        ], $messages);

        $depot = null ;
        if($request->hasFile("depot")){
            $depot = $request['depot']->store('/public/offres');
            $depot= str_replace("public","storage",$depot);
        }
        $input = $request->only(["nomOffre","natureOffre","dateDebut","dateFin","pre-embauche","lienOffre"]);
        $idEntreprise = DB::table("contact_entreprise")->where("idUser",Auth::id())->value("idEntreprise");

        $idOffre = DB::table("offre")->insertGetId([
           "nomOffre" => $input["nomOffre"],
            "natureOffre" => $input["natureOffre"],
            "dateDebut" => $input["dateDebut"],
            "dateFin" => $input["dateFin"],
            "preembauche" => $input["pre-embauche"],
            "idEntreprise" => $idEntreprise,
            "datePublicationOffre" => new \DateTime(),
            "depot" => $depot,
            "lienOffre" => $input["lienOffre"]
        ]);

        $description = $request->only(["contexte","objectif","location"]);

        DB::table("description_offre")->insert([
           "contexte" => preg_replace("#<script.*?</script>#","",nl2br($description["contexte"])),
            "objectif" => preg_replace("#<script.*?</script>#","",nl2br($description["objectif"])),
            "idOffre" => $idOffre,
            "location" => $description["location"]
        ]);

        return redirect(route("afficherUneOffre",["id"=>$idOffre]));
    }


    function editOffre($id) {
        if (Auth::check() && $this->peutModifier($id)){
            return view('offre/edit',['offre'=>Offre::find($id)]);
        }
        return redirect(route('accueil'));
    }

    function storeChanges(Request $request ,$id){
        $messages = [
            'nomOffre.required' => "Le champ nom de l'offre de peut pas être vide.",
            'nomOffre.string' => "Le champ nom de l'offre doit être une chaine de caractères.",
            'nomOffre.min' => "Le champ nom de l'offre doit être composé d'au moins 3 caractères.",
            'natureOffre.required' => "Le champ nature de l'offre de peut pas être vide.",
            'natureOffre.string' => "Le champ nature de l'offre doit être une chaine de caractères.",
            'natureOffre.min' => "Le champ nature de l'offre doit être composé d'au moins 3 caractères.",
            'dateDebut.required' => "Le champ date de début du stage ne peut pas être vide.",
            'dateDebut.date' => "Le champ date de début du stage doit être une date.",
            'dateDebut.after' => "Le stage doit débuter après la date d'aujourd'hui.",
            'dateFin.required' => "Le champ date de fin du stage ne peut pas être vide.",
            'dateFin.date' => "Le champ date de fin du stage doit être une date.",
            'dateFin.after' => "Le stage doit finir après la date de début de stage.",
            'pre-embauche.required' => "Le champ pre-embauche de peut pas être vide.",
            'pre-embauche.string' => "Le champ pre-embauche doit être une chaine de caractères.",
            'pre-embauche.min' => "Le champ pre-embauche doit être composé d'au moins 3 caractères.",
            'pre-embauche.max' => "Le champ pre-embauche doit être composé d'au plus 8 caractères.",
            'context.required' => "Le champ contexte de peut pas être vide.",
            'context.string' => "Le champ contexte doit être une chaine de caractères.",
            'context.min' => "Le champ contexte doit être composé d'au moins 10 caractères.",
            'context.max' => "Le champ contexte doit être composé d'au plus 1000 caractères.",
            'objectif.required' => "Le champ objectif de peut pas être vide.",
            'objectif.string' => "Le champ objectif doit être une chaine de caractères.",
            'objectif.min' => "Le champ objectif doit être composé d'au moins 10 caractères.",
            'objectif.max' => "Le champ objectif doit être composé d'au plus 1000 caractères.",
            'location.required' => "Le champ localisation du stage ne peut pas être vide.",
            'depot.file' => "Le format du fichier déposé n'est pas valide",
            'lienOffre.url' => "Le lien doit être un lien valide : https://www.google.com/",
        ];

        $this->validate($request,[
            "nomOffre" => ["required","string","min:3","max:255"],
            "natureOffre" => ["required","string","min:3","max:255"],
            "dateDebut" => ["required","date","after:today"],
            "dateFin" => ["required","date","after:dateDebut"],
            "pre-embauche" => ["required","string","min:3","max:8"],
            "contexte" => ["required","string","min:10"],
            "objectif" => ["required","string",'min:10'],
            "location" => ["required"],
            "depot" => ["nullable","file"],
            "lienOffre" => ["nullable","url"]
        ], $messages);

        $depot = null ;
        if($request->hasFile("depot")){
            $depot = $request['depot']->store('/public/offres');
            $depot= str_replace("public","storage",$depot);
        }
        $input = $request->only(["nomOffre","natureOffre","dateDebut","dateFin","pre-embauche","lienOffre"]);
        if ($depot != null){
            $offre = DB::table('offre')->where('id',$id)->first();
            $lienDepot = $offre->depot;
            if ($lienDepot != null){
                $lien = public_path().'/'.$lienDepot;
                \File::delete($lien);
            }

            DB::table("offre")->where('id',$id)->update([
                "nomOffre" => $input["nomOffre"],
                "natureOffre" => $input["natureOffre"],
                "dateDebut" => $input["dateDebut"],
                "dateFin" => $input["dateFin"],
                "preembauche" => $input["pre-embauche"],
                "datePublicationOffre" => new \DateTime(),
                "depot" => $depot,
                "lienOffre" => $input["lienOffre"]
            ]);
        }
        else{
            DB::table("offre")->where('id',$id)->update([
                "nomOffre" => $input["nomOffre"],
                "natureOffre" => $input["natureOffre"],
                "dateDebut" => $input["dateDebut"],
                "dateFin" => $input["dateFin"],
                "preembauche" => $input["pre-embauche"],
                "datePublicationOffre" => new \DateTime(),
                "lienOffre" => $input["lienOffre"]
            ]);
        }


        $description = $request->only(["contexte","objectif","location"]);

        DB::table("description_offre")->where('idOffre',$id)->update([
            "contexte" => preg_replace("#<script.*?</script>#","",nl2br($description["contexte"])),
            "objectif" => preg_replace("#<script.*?</script>#","",nl2br($description["objectif"])),
            "location" => $description["location"]
        ]);

        return redirect(route("afficherUneOffre",["id"=>$id]));
    }

    function afficherUneOffre($id){
        if (Auth::check()){
            $offre = Offre::find($id);
            return view('offre/uneOffre',['offre'=>$offre]);
        }
        return redirect(route('register'));
    }

    function afficherOffres() {
        if (Auth::check()){
            $offres = DB::table('offre')->paginate(10);
            return view('offre/afficherOffres', ['offres' => $offres]);
        }
        return redirect(route('register'));
    }


    function isEtu(){
        foreach (Auth::user()->roles as $role){
            if ($role->typeRole == "ETUDIANT"){
                return true;
            }
        }
        return false;
    }

    function sauvegarder($id){
        if (Auth::check() && $this->isEtu()){
            DB::table('offre_cherchee')->insert([
                "idOffre" => $id,
                "idEtudiant" => DB::table("etudiant")->where('idUser',Auth::id())->value('id'),
            ]);
        }
        return redirect(route('afficherOffres'));
    }

    function drop($id){
        if ($this->isEtu()){
            $idEtudiant = DB::table("etudiant")->where('idUser',Auth::id())->value('id');
            DB::table('offre_cherchee')->where("idOffre",$id)->where("idEtudiant", $idEtudiant)->delete();
        }
        return redirect(route('afficherOffres'));
    }

    function offreSaveEtu(){
        if (Auth::check() && Auth::user()->isEtudiant()){
            $etudiant = Etudiant::where('idUser',Auth::id())->first();
            if ($etudiant){
                $offres = $etudiant->offresSaved()->paginate(10);
                return view('/etudiant/mesRecherches',['offres'=>$offres, 'etudiant'=>$etudiant]);
            }

        }
        return redirect(route('register'));
    }

    function delete($id){
        if(Auth::check() && $this->peutModifier($id)){
            DB::table('offre')->where('id',$id)->delete();
            return view('validationSuppression');
        }
    }

    function dropOffreEtu($id){
        if (Auth::check() && $this->isEtu()){
            DB::table('offre')->where('id',$id)->delete();
            $etudiant = Etudiant::where('idUser',Auth::id())->first();
            $offres = $etudiant->offresSaved()->paginate(10);
        }
        if ($etudiant){
               return view('/etudiant/mesRecherches',['offres'=>$offres,'etudiant'=>$etudiant]);
        }
    }


}
