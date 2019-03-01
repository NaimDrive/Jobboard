<?php

namespace App\Http\Controllers;

use App\ContactEntreprise;
use App\ContactParticipe;
use App\Entreprise;
use App\EntrepriseParticipe;
use App\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
   function afficherUnForum($id){
       if (Auth::check()){
           $forum = Forum::find($id);
           return view("forum/afficherUnForum",["forum"=>$forum]);
       }
       return redirect(route('login'));

   }


   function inscriptionForum($id){
       if (Auth::check() && Auth::user()->isContact() ){
           $contact = ContactEntreprise::query()->where("idUser",Auth::id())->first();
           if($contact->entreprise){
               $forum = Forum::find($id);
               return view("forum/inscriptionForum",["forum"=>$forum,"entreprise"=>$contact->entreprise]);
           }
           return redirect(route('accueil'));
       }
       return redirect(route('login'));

   }

   function storeInscription(Request $request, $id)
   {
       $forum = Forum::find($id);

       $contactCo = ContactEntreprise::query()->where('idUser', Auth::id())->first();

       $entreprise = Entreprise::find($contactCo->idEntreprise);

       $entrepriseParticipe = EntrepriseParticipe::query()->where('idEntreprise', $entreprise->id)->first();

       if (!$entrepriseParticipe) {
           $entrepriseParticipe = new EntrepriseParticipe();
           $entrepriseParticipe->idForum = $forum->id;
           $entrepriseParticipe->idEntreprise = $entreprise->id;
           $entrepriseParticipe->created_at = new \DateTime();
           $entrepriseParticipe->updated_at = new \DateTime();
           $entrepriseParticipe->save();
       }


       $contactParticipe = ContactParticipe::query()->where('idEntrepriseParticipe', $entrepriseParticipe->id)
           ->where('idContact', $contactCo->id)->first();

       if (!$contactParticipe) {

           $contactParticipe = new ContactParticipe();
           $contactParticipe->idEntrepriseParticipe = $entrepriseParticipe->id;
           $contactParticipe->idContact = $contactCo->id;
           $contactParticipe->created_at = new \DateTime();
           $contactParticipe->updated_at = new \DateTime();
           $contactParticipe->save();
       }

       $compteur = $request['nbContacts'];
       $this->validate($request, ['nbContacts' => 'required']);

       for ($i = 0; $i < $compteur; $i++) {
           $this->validate($request, [
               'contact_' . $i => "required",
           ]);

           $idContact = $request['contact_' . $i];

           $contactParticipe = ContactParticipe::query()->where('idEntrepriseParticipe', $entrepriseParticipe->id)
               ->where('idContact', $idContact)->first();

           if (!$contactParticipe) {
               $contactParticipe = new ContactParticipe();
               $contactParticipe->idEntrepriseParticipe = $entrepriseParticipe->id;
               $contactParticipe->idContact = $idContact;
               $contactParticipe->created_at = new \DateTime();
               $contactParticipe->updated_at = new \DateTime();
               $contactParticipe->save();
           }
       }

       return redirect(route('afficherUnForum', ['id' => $id]));
   }

   function creerUnForum(){
       if(Auth::check()) {
           foreach (Auth::user()->roles as $role) {
               if ($role->typeRole == "ADMIN") {
                   return view("forum/creerUnForum");
               }
           }
       }
   }

   function enregistrerUnForum(Request $request){

       $this->validate($request,
           [
               "dateForum"=>["required","date"],
               "heureForum"=>["required"],
               "actif"=>["required","string"]
           ]);

        $input=$request->only(["dateForum","heureForum","actif"]);
        $actif = 0;
        if($input["actif"] == "Oui")
            $actif = 1;
        DB::table("forums")->insert([
           "date" => $input["dateForum"],
           "heure" => $input["heureForum"],
           "actif" => $actif,
       ]);

       return redirect(route('accueil'));
   }
}
