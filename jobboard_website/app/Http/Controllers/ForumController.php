<?php

namespace App\Http\Controllers;

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
