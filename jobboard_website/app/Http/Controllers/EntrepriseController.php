<?php

namespace App\Http\Controllers;

use App\AdressEntreprise;
use App\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntrepriseController extends Controller
{
    function canCreate() {
        foreach (Auth::user()->roles as $role){
            if ($role->typeRole == "ADMIN" || $role->typeRole == "CONTACT") return true;
        }
        return false;
    }

    function createEntreprise(){
        if(Auth::check() && $this->canCreate()){
            $contacts = DB::table('contact_entreprise')->where('idEntreprise',null)->get();
            return view('entreprise/createEntreprise', ['contacts' => $contacts]);
        }
        return redirect(route('register'));
    }

    function enregistrerEntreprise(Request $request){
        $userID = Auth::id();

        $contactID = DB::table('contact_entreprise')->where('idUser',$userID)->value('id');

        $messages = [
            'nom.required' => "Le champ raison sociale ne doit pas être vide.",
            'nom.string' => "Le champ raison sociale doit être une chaine de caractère.",
            'description.required' => "Le champ description ne doit pas être vide.",
            'description.string' => "Le champ description doit être une chaine de caractère.",
            'description.min' => "La description doit faire entre 15 et 1000 caractères.",
            'description.max' => "La description doit faire entre 15 et 1000 caractères.",
            'siret.required' => "Le champ siret ne doit pas être vide.",
            'siret.string' => "Le champ siret doit être une chaine de caractère.",
            'siret.min' => "Le numero de siret doit être composé uniquement de 14 chiffres",
            'siret.max' => "Le numero de siret doit être composé uniquement de 14 chiffres",
        ];
        $this->validate($request,
            [
                "nom"=> ["required","string","max:255"],
                "siret"=> ["required","string","min:14","max:14"],
                "description" =>["required", "string", "min:15", 'max:1000'],
            ],$messages);
        $input=$request->only(["nom","siret","description"]);


        $entreprise = DB::table("entreprise")->insertGetId([
            "nom" => $input["nom"],
            "siret" => $input["siret"],
            "description" => preg_replace("#<script.*?</script>#","",nl2br($input["description"])),
            "createur" => $contactID,
            "actif" => 1
        ]);

        DB::table('contact_entreprise')->where('idUser',$userID)->update(['idEntreprise' => $entreprise]);


        $this->validate($request,[
           "nbAdresse"
        ]);

        $compteur = $request["nbAdresse"]+=0;
        for($i = 0; $i < $compteur; $i++) {
            $messages = [
                "adresse_".$i."_rue.required" => "Le champ rue de l'adresse ".$i." ne doit pas être vide.",
                "adresse_".$i."_rue.string" => "Le champ rue de l'adresse ".$i." doit être une chaine de caractère.",
                "adresse_".$i."_ville.required" => "Le champ ville de l'adresse ".$i." ne doit pas être vide.",
                "adresse_".$i."_ville.string" => "Le champ ville de l'adresse ".$i." doit être une chaine de caractère.",
                "adresse_".$i."_codePostal.required" => "Le champ code postal de l'adresse ".$i." ne doit pas être vide.",
                "adresse_".$i."_codePostal.string" => "Le champ code postal de l'adresse ".$i." doit être une chaine de caractère.",
                "adresse_".$i."_codePostal.min" => "Le champ code postal de l'adresse ".$i." doit contenir 5 chiffres.",
                "adresse_".$i."_codePostal.max" => "Le champ code postal de l'adresse ".$i." doit contenir 5 chiffres.",
            ];
            $this->validate($request,[
                "adresse_".$i."_rue" => ['required', "string", "max:255"],
                "adresse_".$i."_ville" => ['required', "string", "max:255"],
                "adresse_".$i."_codePostal" => ['required', "string", "max:5", "min:5"],
            ], $messages);

            $input=$request->only(["adresse_".$i."_rue","adresse_".$i."_ville","adresse_".$i."_codePostal"]);

            DB::table('adress_entreprise')->insert([
               "nomRue" => $input["adresse_".$i."_rue"],
               "ville" => $input["adresse_".$i."_ville"],
               "coordonnePostales" => $input["adresse_".$i."_codePostal"],
                "idEntreprise" => $entreprise,
            ]);
        }

        $this->validate($request,[
            "nbContactExist",
        ]);

        $compteurContact = $request["nbContactExist"]+=0;

        for($i = 0; $i < $compteurContact; $i++){
            $this->validate($request,[
                "contact_".$i =>['required'],
            ]);
            $input = $request->only(["contact_".$i]);

            DB::table('contact_entreprise')->where('id', $input["contact_".$i])->update([
                'idEntreprise' => $entreprise,
            ]);
        }


        $this->validate($request,[
            "nbContact",
        ]);

        $compteurContact = $request["nbContact"]+=0;

        for($i = 0; $i < $compteurContact; $i++){
            $messages = [
                'contact_'.$i.'_nom.required' => "Le champ nom du contact ".$i." ne peut pas être vide.",
                'contact_'.$i.'_nom.string' => "Le champ nom du contact ".$i." doit contenir une chaine de caractère.",
                'contact_'.$i.'_prenom.required' => "Le champ prénom du contact ".$i." ne peut pas être vide.",
                'contact_'.$i.'_prenom.string' => "Le champ prénom du contact ".$i." doit contenir une chaine de caractère.",
                'contact_'.$i.'_mail.required' => "Le champ email du contact ".$i." ne peut pas être vide.",
                'contact_'.$i.'_mail.email' => "Le champ email du contact ".$i." doit être une adresse email.",
                'contact_'.$i.'_civilite.required' => "Le champ civilité du contact ".$i." ne peut pas être vide.",
                'contact_'.$i.'_role.required' => "Le champ role du contact ".$i." ne peut pas être vide.",
                'contact_'.$i.'_role.string' => "Le champ role du contact ".$i." doit contenir une chaine de caractère.",
                'contact_'.$i.'_phone.min' => "Le numéro de téléphone du contact ".$i." doit contenir 10 caractère.",
                'contact_'.$i.'_phone.max' => "Le numéro de téléphone du contact ".$i." doit contenir 10 caractère.",
            ];

            $this->validate($request,[
                "contact_".$i."_civilite" => ['required', "string", "max:255"],
                "contact_".$i."_nom" => ['required', "string", "max:255"],
                "contact_".$i."_prenom" => ['required', "string", "max:255"],
                "contact_".$i."_mail" => ['required', "email", "max:255"],
                "contact_".$i."_phone" => ['nullable', "string", "max:10", "min:10"],
                "contact_".$i."_role" => ['required', "string"],
            ],$messages);

            $input = $request->only(["contact_".$i."_civilite","contact_".$i."_nom",
                "contact_".$i."_prenom","contact_".$i."_mail","contact_".$i."_phone","contact_".$i."_role"]);

            DB::table('contact_entreprise')->insert([
                'nom' => $input["contact_".$i."_nom"],
                'prenom' => $input["contact_".$i."_prenom"],
                'mail' => $input["contact_".$i."_mail"],
                'telephone' => $input["contact_".$i."_phone"],
                'civilite' => $input["contact_".$i."_civilite"],
                'role' => $input["contact_".$i."_role"],
                'idEntreprise' => $entreprise,
                ]);
        }

        return redirect(route('accueil'));
    }

    function isAdmin() {
        foreach (Auth::user()->roles as $role){
            if ($role->typeRole == "ADMIN") return true;
        }
        return false;
    }

    function editEntreprise($id){
        if (Auth::check()){
            $idUser = Auth::id();
            $idEntreprise = DB::table('contact_entreprise')->where('idUser',$idUser)->value('idEntreprise');

            if($idEntreprise == $id || $this->isAdmin()){
                $entreprise = Entreprise::find($id);
                $contacts = DB::table('contact_entreprise')->where('idEntreprise',null)->get();

                return view('entreprise/edit', ['entreprise'=>$entreprise, 'contacts'=>$contacts]);
            }
            return redirect(route('accueil'));
        }
        return redirect(route('register'));
    }

    function storeChanges(Request $request, $id){
        $entreprise = Entreprise::find($id);

        //VALIDATIONS
        $messages = [
            'nom.required' => "Le champ raison sociale ne doit pas être vide.",
            'nom.string' => "Le champ raison sociale doit être une chaine de caractère.",
            'description.required' => "Le champ description ne doit pas être vide.",
            'description.string' => "Le champ description doit être une chaine de caractère.",
            'description.min' => "La description doit faire entre 15 et 1000 caractères.",
            'description.max' => "La description doit faire entre 15 et 1000 caractères.",
            'siret.required' => "Le champ siret ne doit pas être vide.",
            'siret.string' => "Le champ siret doit être une chaine de caractère.",
            'siret.min' => "Le numero de siret doit être composé uniquement de 14 chiffres",
            'siret.max' => "Le numero de siret doit être composé uniquement de 14 chiffres",
            'createur.required' => "Le champ créateur ne peut pas être vide",
            'actif.required' => "Il faut définir la visibilité de l'entreprise sur le site",
            'actif.integer' => "Mauvaise valeur transmise pour la visibilité de l'entreprise",
        ];

        $this->validate($request,
            [
                "nom"=> ["required","string","max:255"],
                "siret"=> ["required","string","min:14","max:14"],
                "description" =>["required", "string", "min:15", 'max:1000'],
                "createur" => ["required"],
                "actif" => ["required", 'integer'],
                "nbAdresse",
                "nbContactExist",
                "nbContact",
            ],$messages);
        $compteurAdresses = $request["nbAdresse"]+=0;
        for($i = 0; $i < $compteurAdresses; $i++) {
            $messages = [
                "adresse_".$i."_rue.required" => "Le champ rue de l'adresse ".$i." ne doit pas être vide.",
                "adresse_".$i."_rue.string" => "Le champ rue de l'adresse ".$i." doit être une chaine de caractère.",
                "adresse_".$i."_ville.required" => "Le champ ville de l'adresse ".$i." ne doit pas être vide.",
                "adresse_".$i."_ville.string" => "Le champ ville de l'adresse ".$i." doit être une chaine de caractère.",
                "adresse_".$i."_codePostal.required" => "Le champ code postal de l'adresse ".$i." ne doit pas être vide.",
                "adresse_".$i."_codePostal.string" => "Le champ code postal de l'adresse ".$i." doit être une chaine de caractère.",
                "adresse_".$i."_codePostal.min" => "Le champ code postal de l'adresse ".$i." doit contenir 5 chiffres.",
                "adresse_".$i."_codePostal.max" => "Le champ code postal de l'adresse ".$i." doit contenir 5 chiffres.",
            ];
            $this->validate($request, [
                "adresse_" . $i . "_rue" => ['required', "string", "max:255"],
                "adresse_" . $i . "_ville" => ['required', "string", "max:255"],
                "adresse_" . $i . "_codePostal" => ['required', "string", "max:255"],
            ],$messages);
        }

        $compteurContactExist = $request["nbContactExist"]+=0;

        for($i = 0; $i < $compteurContactExist; $i++) {
            $this->validate($request, [
                "contact_" . $i => ['required'],
            ]);
        }

        $compteurContact = $request["nbContact"]+=0;

        for($i = 0; $i < $compteurContact; $i++) {
            $messages = [
                'contact_'.$i.'_nom.required' => "Le champ nom du contact ".$i." ne peut pas être vide.",
                'contact_'.$i.'_nom.string' => "Le champ nom du contact ".$i." doit contenir une chaine de caractère.",
                'contact_'.$i.'_prenom.required' => "Le champ prénom du contact ".$i." ne peut pas être vide.",
                'contact_'.$i.'_prenom.string' => "Le champ prénom du contact ".$i." doit contenir une chaine de caractère.",
                'contact_'.$i.'_mail.required' => "Le champ email du contact ".$i." ne peut pas être vide.",
                'contact_'.$i.'_mail.email' => "Le champ email du contact ".$i." doit être une adresse email.",
                'contact_'.$i.'_civilite.required' => "Le champ civilité du contact ".$i." ne peut pas être vide.",
                'contact_'.$i.'_role.required' => "Le champ role du contact ".$i." ne peut pas être vide.",
                'contact_'.$i.'_role.string' => "Le champ role du contact ".$i." doit contenir une chaine de caractère.",
                'contact_'.$i.'_phone.min' => "Le numéro de téléphone du contact ".$i." doit contenir 10 caractère.",
                'contact_'.$i.'_phone.max' => "Le numéro de téléphone du contact ".$i." doit contenir 10 caractère.",
            ];

            $this->validate($request, [
                "contact_" . $i . "_civilite" => ['required', "string", "max:255"],
                "contact_" . $i . "_nom" => ['required', "string", "max:255"],
                "contact_" . $i . "_prenom" => ['required', "string", "max:255"],
                "contact_" . $i . "_mail" => ['required', "string", "max:255"],
                "contact_" . $i . "_phone" => ['nullable', "string", "max:10", "min:10"],
                "contact_" . $i . "_role" => ['required', "string"],
                "isUser_" . $i => ['required'],
            ],$messages);
        }

        //INSERTIONS

        $input=$request->only(["nom","siret","description","createur","actif"]);

        DB::table("entreprise")->where('id',$entreprise->id)->update([
            "nom" => $input["nom"],
            "siret" => $input["siret"],
            "description" => preg_replace("#<script.*?</script>#","",nl2br($input["description"])),
            "createur" => $input["createur"],
            "actif" => $input["actif"],
        ]);


        for($i = 0; $i < $compteurAdresses; $i++) {
            $input=$request->only(["adresse_".$i."_rue","adresse_".$i."_ville","adresse_".$i."_codePostal"]);

            DB::table('adress_entreprise')->insert([
                "nomRue" => $input["adresse_".$i."_rue"],
                "ville" => $input["adresse_".$i."_ville"],
                "coordonnePostales" => $input["adresse_".$i."_codePostal"],
                "idEntreprise" => $entreprise->id,
            ]);
        }

        //DB::table('contact_entreprise')->where('idEntreprise',$entreprise)->where('idUser',null)->delete();

        for($i = 0; $i < $compteurContactExist; $i++){
            $input = $request->only(["contact_".$i]);

            DB::table('contact_entreprise')->where('id', $input["contact_".$i])->update([
                'idEntreprise' => $entreprise,
            ]);
        }

        for($i = 0; $i < $compteurContact; $i++){
            $input = $request->only(["contact_".$i."_civilite","contact_".$i."_nom",
                "contact_".$i."_prenom","contact_".$i."_mail","contact_".$i."_phone","contact_".$i."_role","isUser_".$i]);


            if (substr($input["isUser_".$i],0,6) == "false_" ){

            }
            elseif ($input["isUser_".$i]=="false"){
                DB::table('contact_entreprise')->insert([
                    'nom' => $input["contact_".$i."_nom"],
                    'prenom' => $input["contact_".$i."_prenom"],
                    'mail' => $input["contact_".$i."_mail"],
                    'telephone' => $input["contact_".$i."_phone"],
                    'civilite' => $input["contact_".$i."_civilite"],
                    'role' => $input["contact_".$i."_role"],
                    'idEntreprise' => $entreprise,
                ]);
            }

            else{
                DB::table("contact_entreprise")->where("id", $input["isUser_".$i])->update([
                    'idEntreprise' => NULL,
                ]);
            }

        }

        return redirect(route('afficherUneEntreprise',['id'=>$entreprise->id]));
    }

    function afficheUneEntreprise($id){
        if (Auth::check()){
            $entreprise = Entreprise::find($id);
            if($entreprise && ($entreprise->actif || $entreprise->getCreateur->idUser == Auth::id() || Auth::user()->isAdmin()))
                return view('entreprise/uneEntreprise',['entreprise'=>$entreprise]);
            return redirect(route('accueil'));
        }
        return redirect(route('register'));
    }

    function afficherToutes(){
        if (Auth::check()){
            $entreprises = Entreprise::where('actif',1)->orderBy('nom')->paginate(10);
            return view('entreprise/toutesEntreprises',['entreprises'=>$entreprises]);
        }
        return redirect(route('register'));
    }

}
