<?php

namespace App\Http\Controllers;

use App\ContactEntreprise;
use App\ContactParticipe;
use App\Entreprise;
use App\EntrepriseParticipe;
use App\Etudiant;
use App\EtudiantParticipe;
use App\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ForumController extends Controller
{
   function afficherUnForum($id){
       if (Auth::check()){
           $contact = null;
           $participe = null;
           $etudiant = null;
           if (Auth::user()->isContact()){
               $contact = ContactEntreprise::where('idUser',Auth::id())->first();
               $participe = EntrepriseParticipe::query()->where('idEntreprise', $contact->entreprise->id)->first();
               if(!$contact->entreprise){
                   $contact=null;
               }
           }
           elseif (Auth::user()->isEtudiant()){
               $etudiant = Etudiant::where('idUser',Auth::id())->first();
           }

           $forum = Forum::find($id);
           return view("forum/afficherUnForum",["forum"=>$forum, 'contact'=>$contact, 'participe'=>$participe, 'etu'=>$etudiant,]);

       }
       return redirect(route('register'));
   }

   function afficherLesForums(){
       $forums = Forum::paginate(10);
       return view("forum/afficherLesForums",compact('forums'));
   }

   function modifierUnForum($id)
   {
       if (Auth::check()){
           foreach (Auth::user()->roles as $role) {
               if ($role->typeRole == 'ADMIN') {
                   $forum = Forum::find($id);
                   return view("forum/modifierUnForum", compact("forum"));
               }
               return redirect(route('accueil'));
           }
        }
        return redirect(route('register'));
   }

   function enregistrerModifForum(Request $request, $id){

       $messages = [
           "DateForum.required" => "Veuillez saisir une date valide.",
           "DateForum.date" => "Veuillez saisir une date valide.",
           "HeureForum.required" => "Veuillez saisir une heure valide.",
           "actif.required" => "Veuillez saisir si le forum est actif ou non.",
           "actif.string" => "Veuillez saisir si le forum est actif ou non."
       ];

       $this->validate($request,
           [
               "dateForum"=>["required","date"],
               "heureForum"=>["required"],
               "actif"=>["required","string"]
           ], $messages);

       $input=$request->only(["dateForum","heureForum","actif"]);
       $actif = 0;
       if($input["actif"] == "Oui")
           $actif = 1;
       DB::table("forums")->where("id",$id)->update([
           "date" => $input["dateForum"],
           "heure" => $input["heureForum"],
           "actif" => $actif,
       ]);

       return redirect(route('accueil'));
   }


   function supprimerUnForum($id){
       foreach(Auth::user()->roles as $role) {
           if ($role->typeRole == 'ADMIN') {
               DB::delete('delete from forums where id = ?', [$id]);
           }
       }
       return redirect(route('accueil'));
   }


   function inscriptionForum($id){
       if (Auth::check() && Auth::user()->isContact() ){
           $contact = ContactEntreprise::query()->where("idUser",Auth::id())->first();
           $forum = Forum::find($id);
           if($contact->entreprise && $forum->actif){
               return view("forum/inscriptionForum",["forum"=>$forum,"entreprise"=>$contact->entreprise]);
           }
           return redirect(route('accueil'));
       }
       return redirect(route('register'));

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

       $this->validate($request, ['nbContacts' => 'required']);

       $compteur = $request['nbContacts'];

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

       $messages = [
           "DateForum.required" => "Veuillez saisir une date valide.",
           "DateForum.date" => "Veuillez saisir une date valide.",
           "HeureForum.required" => "Veuillez saisir une heure valide.",
           "actif.required" => "Veuillez saisir si le forum est actif ou non.",
           "actif.string" => "Veuillez saisir si le forum est actif ou non."
       ];

       $this->validate($request,
           [
               "dateForum"=>["required","date"],
               "heureForum"=>["required"],
               "actif"=>["required","string"]
           ], $messages);

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


   function editInscription($id){
       if (Auth::check()){
           $user = ContactEntreprise::query()->where('idUser', Auth::id())->first();

           $entreprise = $user->entreprise;
           if ($user && $entreprise){
               $forum = Forum::find($id);
               if ($forum && $this->entrepriseParticipe($forum->id, $entreprise->id)){
                   $inscription = EntrepriseParticipe::find($this->entrepriseParticipe($forum->id, $entreprise->id));
                   return view('forum/editInscription', ['forum'=>$forum,'entreprise'=>$inscription]);
               }


               return redirect(route('accueil'));

           }
           return redirect(route('accueil'));
       }
       return redirect(route('register'));

   }

   function storeEdit(Request $request,$id){
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


       $contacts = $entrepriseParticipe->contacts;
       foreach ($contacts as $contact){
           $contact->delete();
       }

       $this->validate($request, ['nbContacts' => 'required']);

       $compteur = $request['nbContacts'];

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

    function entrepriseParticipe($idForum, $idEntreprise){
        $forum = Forum::find($idForum);
        if($forum){
            foreach ($forum->entreprises as $entreprise){
                if ($entreprise->idEntreprise == $idEntreprise){
                    return $entreprise->id;
                }
            }
        }
        return null;
    }

    function desinscrire($id){
       if (Auth::check() && Auth::user()->isContact()){
           $forum = Forum::find($id);
           $contact = ContactEntreprise::where('idUser',Auth::id())->first();
           if($forum && $this->entrepriseParticipe($forum->id,$contact->idEntreprise)){
               $entrepriseParticipe = EntrepriseParticipe::where('idEntreprise',$contact->idEntreprise)->first();
               $entrepriseParticipe->delete();
           }
       }
       return redirect(route('afficherUnForum',['id'=>$id]));
    }

    function etudiantInscription($idEtudiant, $idEntreprise){
       $etudiant = new EtudiantParticipe();
       $etudiant->idEtudiant = $idEtudiant;
       $etudiant->idEntrepriseParticipe = $idEntreprise;
       $etudiant->save();
       return redirect(URL::previous());
    }

    function etudiantDesinscription($idEtudiant, $idEntreprise){
        $etudiant = EtudiantParticipe::where('idEtudiant',$idEtudiant)->where('idEntrepriseParticipe', $idEntreprise)->delete();
        return redirect(URL::previous());
    }



}
