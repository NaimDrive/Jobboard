<?php

namespace App\Http\Controllers;

use App\ContactEntreprise;
use App\Etudiant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditPasswordController extends Controller
{
    public function editPassword(){
        if (Auth::check()){
            $user = Auth::user();
            return view('auth/editPassword', ['user'=>$user]);
        }
        return redirect(route('register'));
    }

    public function storeEditPassword(Request $request){

        $user = Auth::user();

        $message = [
            'oldPassword.required'=>'Le champ ancien mot de passe ne peut pas être vide',
            'newPassword.required' => 'Le champ nouveau mot de passe ne peut pas être vide',
            'newPassword.min' => 'Le champ nouveau mot de passe doit faire au moins 6 caractères',
            'confirmPassword.same' => 'La confirmation de mot de passe doit être identique au nouveau mot de passe',
        ];

        $this->validate($request,[
            'oldPassword'=> ['required', 'string'],
            'newPassword'=>['required', 'string', 'min:6'],
            'confirmPassword'=>['required', 'same:newPassword']
        ],$message);

        if (Hash::check($request['oldPassword'],$user->password)){
            $user->password = Hash::make($request['newPassword']);
            $user->save();

            if($user->isEtudiant()){
                $etudiant = Etudiant::where('idUser',$user->id)->first();
                return redirect(route('consult_profile',['id'=>$etudiant->id]));
            }
            elseif ($user->isContact()){
                $contact = ContactEntreprise::where('idUser',$user->id)->first();
                return redirect(route('afficherUnContact',['id'=>$contact->id]));
            }
            elseif ($user->isAdmin()){
                return redirect(route('accueil'));
            }
        }

        $data['errorMessage'] = 'Le mot de passe actuel n\'est pas correct';
        return redirect()->route('password', $data);



    }
}
