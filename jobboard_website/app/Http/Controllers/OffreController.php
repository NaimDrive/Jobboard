<?php

namespace App\Http\Controllers;

use App\Entreprise;
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
        ]);

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
           "contexte" => $description["contexte"],
            "objectif" => $description["objectif"],
            "idOffre" => $idOffre,
            "location" => $description["location"]
        ]);

        return redirect(route("afficherUneOffre",["id"=>$idOffre]));
    }


    function editOffre($id) {
        if ($this->peutModifier($id)){
            return view('offre/edit',['offre'=>Offre::find($id)]);
        }
        return redirect(route('accueil'));
    }

    function storeChanges(Request $request ,$id){
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
        ]);

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
            "contexte" => $description["contexte"],
            "objectif" => $description["objectif"],
            "location" => $description["location"]
        ]);

        return redirect(route("afficherUneOffre",["id"=>$id]));
    }

    function afficherUneOffre($id){
        $offre = Offre::find($id);
        return view('offre/uneOffre',['offre'=>$offre]);
    }

    function afficherOffres() {
        $offres = DB::table('offre')->get();
        return view('offre/afficherOffres', ['offres' => $offres]);
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
        if ($this->isEtu()){
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
        return view('/etudiant/mesRecherches');
    }


    function delete($id){
        if($this->peutModifier($id)){
            DB::table('offre')->where('id',$id)->delete();
            return view('validationSuppression');
        }
    }


}
