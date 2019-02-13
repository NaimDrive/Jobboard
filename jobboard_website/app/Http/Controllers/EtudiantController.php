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
        echo "test";
        $this->validate($request,
            [
                'civilite' => ['required'],
                'dateNaissance' => ['required'],
                'adressePostale' => ['required'],
                'adresseMail' => ['required'],
                'nomLien' => ['required'],
                'lienExterne' => ['required'],
            ]);

        $input=$request->only(['civilite','dateNaissance','adressePostale','adresseMail','nomLien','lienExterne']);
        $user_id= Auth::id();

        DB::table('etudiant')->insert([
            'civilite' => $input['civilite'],
            'dateDeNaissance' => $input['dateNaissance'],
            'mail' => $input['adresseMail'],
            'LienExterne' => $input['lienExterne'],
            'CoordonnéePostal' => $input['adressePostale'],
            'idUser' => $user_id,
        ]);

        $etu = DB::table('etudiant')->where('idUser', $user_id)->first();

        DB::table('reference_lien')->insert([
            'nomReference' => $input['nomLien'],
            'UrlReference' => $input['lienExterne'],
            'idEtudiant' => $etu['id'],
        ]);

        return redirect(route('home'));
    }
}