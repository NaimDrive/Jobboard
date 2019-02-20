<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offre ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            elseif($role->typeRole == 'ADMIN'){
                $peutCreer = true;
            }
        }
        return $peutCreer;
    }

    function creerOffre(){
        if (Auth::check() && $this->peutCreer()){
            return view('offre/createOffre');
        }
    }


    function enregistrerOffre(Request $request){
        $this->validate($request,[
           "nomOffre" => ["required","string","min:3","max:255"],
            "natureOffre" => ["required","string","min:3","max:255"],
            "dateDebut" => ["required","date","after:today"],
            "dateFin" => ["required","date","after:dateDebut"],
            "pre-embauche" => ["required","string","min:3","max:8"],
            "contexte" => ["required","string","min:10"],
            "objectif" => ["required","string",'min:10']
        ]);

        $input = $request->only(["nomOffre","natureOffre","dateDebut","dateFin","pre-embauche"]);
        $idEntreprise = DB::table("contact_entreprise")->where("idUser",Auth::id())->value("idEntreprise");

        $idOffre = DB::table("offre")->insertGetId([
           "nomOffre" => $input["nomOffre"],
            "natureOffre" => $input["natureOffre"],
            "dateDebut" => $input["dateDebut"],
            "dateFin" => $input["dateFin"],
            "pre-embauche" => $input["pre-embauche"],
            "idEntreprise" => $idEntreprise,
            "datePublicationOffre" => new \DateTime()
        ]);

        $description = $request->only(["contexte","objectif"]);

        DB::table("description_offre")->insert([
           "contexte" => $description["contexte"],
            "objectif" => $description["objectif"],
            "idOffre" => $idOffre
        ]);

        return redirect(route("afficherUneOffre",["id"=>$idOffre]));
    }

    function afficherUneOffre($id){
        $offre = Offre::find($id);
        return view('offre/uneOffre',['offre'=>$offre]);
    }


}