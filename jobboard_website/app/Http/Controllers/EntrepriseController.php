<?php

namespace App\Http\Controllers;

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

        DB::table("Entreprise")->insert([
            "nom" => $input["nom"],
            "siret" => $input["siret"]
        ]);

        return redirect(route('home'));
    }

}
