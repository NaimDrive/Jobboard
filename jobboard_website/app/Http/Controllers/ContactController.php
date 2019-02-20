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
        return redirect(route('login'));
    }

    function storeChanges(Request $request){

        $this->validate($request,[
            'nom' => ['required','string','max:255'],
            'prenom' => ['required','string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'photo' => ['nullable','image'],
            'civilite' => ['required', 'string'],
            'telephone' =>['required', 'string', 'min:10', 'max:10'],
            'entreprise' => ['required'],
            'idUser' => ['required']
        ]);

        $photo = null;

        if ($request->hasFile('photo')) {
            $photo = $request['photo']->store('/public/images/profilPicture');
            $photo= str_replace("public","storage",$photo);
        }

        $input = $request->only(['nom','prenom','email','civilite','telephone','entreprise','idUser']);

        if ($photo == null){
            DB::table('users')->where('id',$input['idUser'])->update([
                'nom' => $input['nom'],
                'prenom' => $input['prenom'],
                'email' => $input['email'],
                'updated_at' => new \DateTime()
            ]);
        }
        else{
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
        ]);

        return redirect(route('afficherUnContact', DB::table('contact_entreprise')->where('idUser',$input['idUser'])->value('id')));
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
