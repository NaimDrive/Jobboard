<?php

namespace App\Http\Controllers;

use App\ContactEntreprise;
use App\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    function isAdmin() {
        foreach (Auth::user()->roles as $role){
            if ($role->typeRole == "ADMIN") return true;
        }
        return false;
    }

    function editContact($id){
        if (Auth::check()) {
            $contactId = DB::table('contact_entreprise')->where('idUser', Auth::id())->value('id');

            if ($contactId == $id || $this->isAdmin()) {
                $contact = ContactEntreprise::find($id);
                $entreprises = DB::table('entreprise')->get();

                return view('contact/edit', ['contact' => $contact, 'entreprises' => $entreprises]);
            }
            return redirect(route('accueil'));
        }
        return redirect(route('register'));
    }

    function storeChanges(Request $request){
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
            'role.required' => "Le champ role ne peut pas être vide.",
            'role.string' => "Le champ role doit contenir une chaine de caractère.",
            'telephone.min' => "Le numéro de téléphone doit contenir 10 caractère.",
            'telephone.max' => "Le numéro de téléphone doit contenir 10 caractère.",
            'actif.required' => "Il faut définir la visibilité du profil sur le site"
        ];

        $this->validate($request,[
            'nom' => ['required','string','max:255'],
            'prenom' => ['required','string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'photo' => ['nullable','image'],
            'civilite' => ['required', 'string'],
            'telephone' =>['nullable', 'string', 'min:10', 'max:10'],
            'role' => ['required', 'string', 'max:100'],
            'entreprise' => ['required'],
            'idUser' => ['required'],
            'actif' => ['required', 'integer'],
        ], $messages);

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request['photo']->store('/public/images/profilPicture');
            $photo= str_replace("public","storage",$photo);
        }

        $input = $request->only(['nom','prenom','email','civilite','telephone','entreprise','idUser','role','actif']);

        if ($photo == null){
            DB::table('users')->where('id',$input['idUser'])->update([
                'nom' => $input['nom'],
                'prenom' => $input['prenom'],
                'email' => $input['email'],
                'updated_at' => new \DateTime()
            ]);
        }
        else{
            $user = DB::table('users')->where('id',$input['idUser'])->first();
            $image = $user->picture;
            if ($image != 'images/user-icon.png'){
                $lien = public_path().'/'.$image;
                \File::delete($lien);
            }


            DB::table('users')->where('id',$input['idUser'])->update([
                'nom' => $input['nom'],
                'prenom' => $input['prenom'],
                'email' => $input['email'],
                'picture' => $photo,
                'updated_at' => new \DateTime()
            ]);
        }


        DB::table('contact_entreprise')->where('idUser',$input['idUser'])->update([
            'nom' => $input['nom'],
            'prenom' => $input['prenom'],
            'mail' => $input['email'],
            'telephone' => $input['telephone'],
            'civilite' => $input['civilite'],
            'idEntreprise' => ($input['entreprise']=='null'? NULL : $input['entreprise']),
            'updated_at' => new \DateTime(),
            'role' => $input['role'],
            'actif' => $input['actif'],
        ]);

        return redirect(route('afficherUnContact', DB::table('contact_entreprise')->where('idUser',$input['idUser'])->value('id')));
    }

    function afficherUnContact($id){
        if (Auth::check()){
            $contact = ContactEntreprise::find($id);
            if($contact && ($contact->actif || $contact->idUser == Auth::id() || Auth::user()->isAdmin()))
                return view('contact/unContact',['contact'=>$contact]);
            return redirect(route('accueil'));
        }
        return redirect(route('register'));

    }

    function afficherContacts(){

        if (Auth::check()){
            $contacts = ContactEntreprise::where('actif',1)->orderBy('nom')->orderBy('prenom')->paginate(10);
            return view('contact/toutContacts',['contacts'=>$contacts]);
        }
        return redirect(route('register'));
    }
}
