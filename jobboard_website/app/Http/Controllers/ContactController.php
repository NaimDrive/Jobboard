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
            $userId = DB::table('contact_entreprise')->where('idUser', Auth::id())->value('idUser');

            if ($userId == $id || $this->isAdmin()) {
                $contact = DB::table('contact_entreprise')->where('idUser', $id)->first();
                $contactEntreprise = DB::table('contact_entreprise')->where('idUser', $userId)->value('idEntreprise');
                $entreprises = DB::table('entreprise')->get();

                return view('contact/edit', ['contact' => $contact, 'contactEntreprise' => $contactEntreprise, 'entreprises' => $entreprises]);
            }
            return redirect(route('accueil'));
        }
        return redirect(route('login'));
    }

    function storeChanges(Request $request){
        $user = Auth::id();

        $this->validate($request,[
            'nom' => ['required','string','max:255'],
            'prenom' => ['required','string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'photo' => ['nullable','image'],
            'civilite' => ['required', 'string'],
            'telephone' =>['required', 'string', 'min:10', 'max:10'],
            'entreprise' => ['required']
        ]);

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request['photo']->store('/public/images/profilPicture');
            $photo= str_replace("public","storage",$photo);
        }

        $input = $request->only(['nom','prenom','email','civilite','telephone','entreprise']);

        DB::table('users')->where('id',$user)->update([
            'nom' => $input['nom'],
            'prenom' => $input['prenom'],
            'email' => $input['email'],
            'picture' => $photo,
            'updated_at' => new \DateTime()
        ]);

        DB::table('contact_entreprise')->where('idUser',$user)->update([
            'nom' => $input['nom'],
            'prenom' => $input['prenom'],
            'mail' => $input['email'],
            'telephone' => $input['telephone'],
            'civilite' => $input['civilite'],
            'idEntreprise' => ($input['entreprise']=='null'? NULL : $input['entreprise']),
        ]);

        return redirect(route('accueil'));
    }

    function afficherUnContact($id){
        $contact = ContactEntreprise::find($id);
        return view('contact/unContact',['contact'=>$contact]);
    }

    function afficherContacts(){
        $contacts = DB::table('contact_entreprise')->get();
        return view('contact/toutContacts',['contacts'=>$contacts]);
    }
}
