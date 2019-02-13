<?php

namespace App\Http\Controllers;

use App\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntrepriseController extends Controller
{
    function createEntreprise(){
        if(Auth::check()){
            return view('entreprise/createEntreprise');
        }
        return redirect(route('login'));
    }

    function enregistrerEntreprise(Request $request){
        $this->validate($request,
            [
                "nom"=> ["required","string","max:255"],
                "siret"=> ["required","string","min:14","max:14"],
            ]);
        $input=$request->only(["nom","siret"]);


        $entreprise = DB::table("entreprise")->insertGetId([
            "nom" => $input["nom"],
            "siret" => $input["siret"],
        ]);


        $this->validate($request,[
           "nbAdresse"
        ]);

        $compteur = $request["nbAdresse"]+=0;
        for($i = 0; $i < $compteur; $i++) {
            $this->validate($request,[
                "adresse_".$i."_rue" => ["string", "max:255"],
                "adresse_".$i."_ville" => ["string", "max:255"],
                "adresse_".$i."_codePostal" => ["string", "max:255"],
            ]);

            $input=$request->only(["adresse_".$i."_rue","adresse_".$i."_ville","adresse_".$i."_codePostal"]);

            DB::table('adress_entreprise')->insert([
               "nomRue" => $input["adresse_".$i."_rue"],
               "ville" => $input["adresse_".$i."_ville"],
               "coordonnePostales" => $input["adresse_".$i."_codePostal"],
                "idEntreprise" => $entreprise,
            ]);
        }

        return redirect(route('accueil'));
    }

    function afficheUneEntreprise($id){
        $entreprise = Entreprise::find($id);
        return view('entreprise/uneEntreprise',['entreprise'=>$entreprise]);
    }

}
