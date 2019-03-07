<?php

namespace App\Http\Controllers;

use App\ContactEntreprise;
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
                'photo' => ['nullable','image'],
                'civilite' => ['required', 'string'],
                'telephone' =>['nullable', 'string', 'min:10', 'max:10'],
                'role' => ['required', 'string', 'max:100'],
                'dateNaissance' => ['nullable', 'date'],
                'ville' => ['nullable', 'string', 'max:255'],
                'adresse' => ['nullable', 'string', 'max:255'],
                'codepostal' => ['nullable', 'string', 'max:5', 'min:5']
            ]);

            $photo = 'images/user-icon.png';

            if ($request->hasFile('photo')) {
                $photo = $request['photo']->store('/public/images/profilPicture');
                $photo= str_replace("public","storage",$photo);
            }

            $input = $request->only('nom','prenom','email','password','civilite','telephone','role');

            $userID = DB::table('users')->insertGetId([
                'nom'=>$input['nom'],
                'prenom'=> $input['prenom'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'picture' => $photo,
                'created_at' => new \DateTime(),
            ]);

            DB::table('contact_entreprise')->insert([
                'nom' => $input['nom'],
                'prenom' => $input['prenom'],
                'mail' => $input['email'],
                'telephone' => $input['telephone'],
                'civilite' => $input['civilite'],
                'role' => $input['role'],
                'idUser' => $userID,
                'created_at' => new \DateTime(),
            ]);

            DB::table('definir')->insert([
                'idRole'=>3,
                'idUser'=>$userID,
            ]);
        }

        else{
            $this->validate($request, [
                'nom' => ['required','string','max:255'],
                'prenom' => ['required','string','max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'photo' => ['nullable','image'],
                'civilite' => ['required', 'string'],
                'telephone' =>['nullable', 'string', 'min:10', 'max:10'],
                'dateNaissance' => ['required', 'date'],
                'ville' => ['required', 'string', 'max:255'],
                'adresse' => ['required', 'string', 'max:255'],
                'codepostal' => ['required', 'string', 'max:5', 'min:5'],
                'etudes'=> ['required', 'string'],
            ]);

            $photo = 'images/user-icon.png';

            if ($request->hasFile('photo')) {
                $photo = $request['photo']->store('/public/images/profilPicture');
                $photo= str_replace("public","storage",$photo);
            }

            $input = $request->only('nom','prenom','email','password','civilite','dateNaissance',
                'ville', 'adresse', 'codepostal','etudes');

            $userID = DB::table('users')->insertGetId([
                'nom'=>$input['nom'],
                'prenom'=> $input['prenom'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'picture' => $photo,
                'created_at' => new \DateTime(),
            ]);

            DB::table('etudiant')->insert([
                'civilite' => $input['civilite'],
                'DateDeNaissance' => $input['dateNaissance'],
                'adresse' => $input['adresse'],
                'codePostal' => $input['codepostal'],
                'ville' => $input['ville'],
                'idUser' => $userID,
                'actif' => 1,
                'rechercheStage' => 1,
                'etudes' => $input['etudes'],
                'created_at' => new \DateTime(),
            ]);
            DB::table('definir')->insert([
                'idRole'=>2,
                'idUser'=>$userID,
            ]);
        }

        if (Auth::loginUsingId($userID)){
            return redirect(route('accueil'));
        }

        return redirect(route('login'));
    }




    public function choose($id){
        return view('auth/choose', ['id' => $id]);
    }

    public function storeChoice(Request $request, $id){
        $this->validate($request,[
            'status' => ['required' , 'string']
        ]);

        $input = $request->only('status');
        $status = $input['status'];


        if ($status == "entreprise"){
            $this->validate($request, [
                'civilite' => ['required', 'string'],
                'telephone' =>['nullable', 'string', 'min:10', 'max:10'],
                'role' => ['required', 'string', 'max:100'],
                'dateNaissance' => ['nullable', 'date'],
                'ville' => ['nullable', 'string', 'max:255'],
                'adresse' => ['nullable', 'string', 'max:255'],
                'codepostal' => ['nullable', 'string', 'max:5', 'min:5']
            ]);

            $input = $request->only('civilite','telephone','role');

            $contact = new ContactEntreprise();
            $contact->nom = Auth::user()->nom;
            $contact->prenom = Auth::user()->prenom;
            $contact->mail = Auth::user()->email;
            $contact->telephone = $input['telephone'];
            $contact->civilite = $input['civilite'];
            $contact->idUser = Auth::user()->id;
            $contact->role = $input['role'];
            $contact->created_at = new \DateTime();

            $contact->save();


            DB::table('definir')->insert([
                'idRole'=>3,
                'idUser'=>$id,
            ]);
        }

        else{
            $this->validate($request, [
                'civilite' => ['required', 'string'],
                'telephone' =>['nullable', 'string', 'min:10', 'max:10'],
                'dateNaissance' => ['required', 'date'],
                'ville' => ['required', 'string', 'max:255'],
                'adresse' => ['required', 'string', 'max:255'],
                'codepostal' => ['required', 'string', 'max:5', 'min:5'],
                'etudes' => ['required', 'string'],
            ]);

            $input = $request->only('civilite','dateNaissance',
                'ville', 'adresse', 'codepostal','etudes');

            DB::table('etudiant')->insert([
                'civilite' => $input['civilite'],
                'DateDeNaissance' => $input['dateNaissance'],
                'adresse' => $input['adresse'],
                'codePostal' => $input['codepostal'],
                'ville' => $input['ville'],
                'idUser' => $id,
                'actif' => 1,
                'rechercheStage' => 1,
                'etudes' => $input['etudes'],
                'created_at' => new \DateTime(),
            ]);
            DB::table('definir')->insert([
                'idRole'=>2,
                'idUser'=>$id,
            ]);
        }

        return redirect(route('accueil'));

    }
}
