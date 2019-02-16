<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    function editContact($id){
        $userId = DB::table('contact_entreprise')->where('idUser',Auth::id())->value('idUser');

        if ($userId == $id){
            $contact = DB::table('contact_entreprise')->where('idUser', $userId)->first();
            $user = Auth::user();

            return view('contact/edit', ['contact' => $contact , 'user' => $user]);
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
        ]);

        $input = $request->only(['nom','prenom','email','civilite','telephone']);

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
            'civilite' => $input['civilite']
        ]);

        return redirect(route('accueil'));
    }
}
