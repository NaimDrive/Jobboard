<?php
/**
 * Created by PhpStorm.
 * User: Loane
 * Date: 11/02/2019
 * Time: 15:30
 */

namespace App\Http\Controllers;

use App\Etudiant;
use App\ReferenceLien;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EtudiantController extends Controller
{
    function modifierProfile()
    {
        return view('etudiant/editProfile');
    }

    function consulterProfile()
    {
        return view('etudiant/consultProfile');
    }

    function creerEtudiant(){
        if(Auth::check()){
            return view('etudiant/creerEtudiant');
        }
        return redirect(route('login'));
    }



    function enregistrerEtudiant(Request $request){
 
        $user_id= Auth::id();

        $this->validate($request,
            [
                "civilite"=> "required",
                "dateNaissance"=> "required",
                "ville"=> "required",
                "adresse"=> "required",
                "codepostal"=> "required",
                "adresseMail"=> "required",
                "nomLien"=> "required",
                "lienExterne"=> "required",
            ]);

        $input=$request->only(["civilite","dateNaissance","ville","adresse","codepostal","adresseMail","nomLien","lienExterne"]);
        

        DB::table("etudiant")->insert([
            "civilite" => $input["civilite"],
            "dateDeNaissance" => $input["dateNaissance"],
            "mail" => $input["adresseMail"],
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


    

        
    
}