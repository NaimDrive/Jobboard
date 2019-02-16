<?php

namespace App\Http\Controllers;

use App\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    function editContact($id){
        $userId = DB::table('contact_entreprise')->where('idUser',Auth::id())->value('idUser');

        if ($userId == $id){
            $contact = DB::table('contact_entreprise')->where('idUser', $userId)->first();
            $contactEntreprise = DB::table('contact_entreprise')->where('idUser', $userId)->value('idEntreprise');
            $entreprises = DB::table('entreprise')->get();

            return view('contact/edit', ['contact' => $contact ,'contactEntreprise'=>$contactEntreprise, 'entreprises'=>$entreprises]);
        }
        return redirect(route('accueil'));
    }

    function storeChanges(Request $request){
        $user = Auth::id();

        $this->validate($request,[
            'nom' => ['required','string','max:255'],
            'prenom' => ['required','string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'civilite' => ['required', 'string'],
            'telephone' =>['required', 'string', 'min:10', 'max:10'],
            'entreprise' => ['required']
        ]);

        $input = $request->only(['nom','prenom','email','civilite','telephone','entreprise']);

        DB::table('users')->where('id',$user)->update([
            'nom' => $input['nom'],
            'prenom' => $input['prenom'],
            'email' => $input['email'],
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
}
