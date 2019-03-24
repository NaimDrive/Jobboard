<?php

namespace App\Http\Controllers;

use Anhskohbo\NoCaptcha\NoCaptcha;
use App\ContactEntreprise;
use App\Rules\Captcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class InscriptionController extends Controller
{
    public function formRegister(){
        if(Auth::check()){
            return redirect(route('accueil'));

        }
        return view('auth/connexion');
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
            'status' => ['required' , 'string'],
            'g-recaptcha-response' => new Captcha(),
        ]);

        $input = $request->only('status');
        $status = $input['status'];


        if ($status == "entreprise"){
            $messages = [
                'nom.required' => "Le champ nom ne peut pas être vide.",
                'nom.string' => "Le champ nom doit contenir une chaine de caractère.",
                'prenom.required' => "Le champ prénom ne peut pas être vide.",
                'prenom.string' => "Le champ prénom doit contenir une chaine de caractère.",
                'email.required' => "Le champ email ne peut pas être vide.",
                'email.email' => "Le champ email doit être une adresse email.",
                'email.unique:users'=> "L'adresse email est déjà utilisée.",
                'photo.image'=> "Le champ photo doit contenir une image.",
                'civilite.required' => "Le champ civilité ne peut pas être vide.",
                'password.required' => "Le champ mot de passe ne peut pas être vide.",
                'password.string' => "Le champ mot de passe doit contenir une chaine de caractère.",
                'password.min' => "Le mot de passe doit contenir au moins 6 caractère.",
                'password.confirm' => "Le mot de passe doit être correctement confirmé.",
                'role.required' => "Le champ role ne peut pas être vide.",
                'role.string' => "Le champ role doit contenir une chaine de caractère.",
                'telephone.min' => "Le numéro de téléphone doit contenir 10 caractère.",
                'telephone.max' => "Le numéro de téléphone doit contenir 10 caractère.",
            ];

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
            ],$messages);

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
                'actif' => 1,
            ]);

            DB::table('definir')->insert([
                'idRole'=>3,
                'idUser'=>$userID,
            ]);
        }

        else{

            $messages = [
                'nom.required' => "Le champ nom ne peut pas être vide.",
                'nom.string' => "Le champ nom doit contenir une chaine de caractère.",
                'prenom.required' => "Le champ prénom ne peut pas être vide.",
                'prenom.string' => "Le champ prénom doit contenir une chaine de caractère.",
                'email.required' => "Le champ email ne peut pas être vide.",
                'email.email' => "Le champ email doit être une adresse email.",
                'email.unique:users'=> "L'adresse email est déjà utilisée.",
                'photo.image'=> "Le champ photo doit contenir une image.",
                'civilite.required' => "Le champ civilité ne peut pas être vide.",
                'password.required' => "Le champ mot de passe ne peut pas être vide.",
                'password.string' => "Le champ mot de passe doit contenir une chaine de caractère.",
                'password.min' => "Le mot de passe doit contenir au moins 6 caractère.",
                'password.confirm' => "Le mot de passe doit être correctement confirmé.",
                'dateNaissance.required' => "Le champ date de naissance ne peut pas être vide.",
                'dateNaissance.string' => "Le champ date de naissance doit contenir une date.",
                'ville.required' => "Le champ adresse ne peut pas être vide.",
                'adresse.string' => "Le champ adresse doit contenir une chaine de caractère.",
                'etudes.required' => "Le champ études ne peut pas être vide.",
                'etudes.string' => "Le champ études doit contenir une chaine de caractère.",
                'codepostal.required' => "Le champ code postal ne peut pas être vide.",
                'codepostal.string' => "Le champ code postal doit contenir une chaine de caractère.",
                'codepostal.max' => "Le champ code postal doit être composé de 5 chiffres",
                'codepostal.min' => "Le champ code postal doit être composé de 5 chiffres",
            ];
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
            ],$messages);

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

        return redirect(route('register'));
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
            $contact->actif = 1;

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
