<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OffreController extends Controller
{

    function peutCreer(){
        $peutCreer=false;
        foreach(Auth::user()->roles as $role){
            if($role->typeRole == 'ADMIN' || $role->typeRole == 'CONTACT'){
                $peutCreer = true;
            }
        }
        return $peutCreer;
    }

    function creerOffre(){
        if (Auth::check() && $this->peutCreer()){
            return view('offre/createOffre');
        }
    }
}
