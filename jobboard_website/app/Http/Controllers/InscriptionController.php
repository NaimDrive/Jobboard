<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InscriptionController extends Controller
{
    public function formRegister(){
        if(Auth::check()){
            return redirect(route('logout'));

        }
        return view('auth/register');
    }

    public function isEntreprise(Request $request){
        $this->validate($request,[
            'status' => ['required' , 'string']
        ]);

        return $request == "entreprise";
    }


    public function enregistrerUtilisateur(Request $request)
    {
        $this->validate($request,[
            'status' => ['required' , 'string']
        ]);

        $input = $request->only('status');
        $status = $input['status'];


        if ($status == "entreprise"){
            $this->validate($request, [
                'nom' => ['required','string','max:255'],
                'prenom' => ['required','string','max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'civilite' => ['required', 'string'],
                'telephone' =>['required', 'string', 'min:10', 'max:10'],
                'dateNaissance' => ['nullable', 'date'],
                'ville' => ['nullable', 'string', 'max:255'],
                'adresse' => ['nullable', 'string', 'max:255'],
                'codepostal' => ['nullable', 'string', 'max:5', 'min:5']
            ]);

            $input = $request->only('nom','prenom','email','password','civilite','telephone');
            $userID = DB::table('users')->insertGetId([
                'nom'=>$input['nom'],
                'prenom'=> $input['prenom'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'created_at' => new \DateTime(),
            ]);

            DB::table('contact_entreprise')->insert([
                'nom' => $input['nom'],
                'prenom' => $input['prenom'],
                'mail' => $input['email'],
                'telephone' => $input['telephone'],
                'civilite' => $input['civilite'],
                'idUser' => $userID,
            ]);
        }

        else{
            $this->validate($request, [
                'nom' => ['required','string','max:255'],
                'prenom' => ['required','string','max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'civilite' => ['required', 'string'],
                'telephone' =>['nullable', 'string', 'min:10', 'max:10'],
                'dateNaissance' => ['required', 'date'],
                'ville' => ['required', 'string', 'max:255'],
                'adresse' => ['required', 'string', 'max:255'],
                'codepostal' => ['required', 'string', 'max:5', 'min:5']
            ]);

            $input = $request->only('nom','prenom','email','password','civilite','dateNaissance',
                'ville', 'adresse', 'codepostal');

            $userID = DB::table('users')->insertGetId([
                'nom'=>$input['nom'],
                'prenom'=> $input['prenom'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            DB::table('etudiant')->insert([
                'civilite' => $input['civilite'],
                'DateDeNaissance' => $input['dateNaissance'],
                'adresse' => $input['adresse'],
                'codePostal' => $input['codepostal'],
                'ville' => $input['ville'],
                'idUser' => $userID,
            ]);
        }

        return redirect(route('login'));
    }
}
