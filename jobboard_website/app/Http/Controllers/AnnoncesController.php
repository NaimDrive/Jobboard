<?php

namespace App\Http\Controllers;

use App\Annonces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnoncesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            foreach (Auth::user()->roles as $role) {
                if ($role->typeRole == 'ADMIN') {
                    $annonces = Annonces::paginate(12);
                    return view('annonce/afficherLesAnnonces', compact('annonces'));
                }
            }
        }
        return redirect(route('accueil'));
    }

    public function afficherUneAnnonce($id)
    {
        $annonce = Annonces::find($id);
        return view('annonce/afficherUneAnnonce', ['annonce' => $annonce]);
    }

    public function modiferUneAnnonce($id)
    {
        if (Auth::check()) {
            foreach (Auth::user()->roles as $role) {
                if ($role->typeRole == 'ADMIN') {
                    $annonce = Annonces::find($id);
                    $posMax = Annonces::orderBy('position', 'desc')->value('position');
                    return view('annonce/modifierUneAnnonce', ['annonce' => $annonce, 'posMax' => $posMax]);
                }
                return redirect(route('accueil'));
            }
        }
        return redirect(route('register'));
    }

    function enregistrerModifAnnonce(Request $request, $id)
    {
        $messages = [
            "title.required" => "Veuillez saisir un titre valide.",
            "content.required" => "Veuillez saisir un contenu valide.",
            "datePublication.required" => "Veuillez saisir une date valide.",
            "datePublication.date" => "Veuillez saisir une date valide.",
            "position.required" => "Veuillez saisir une position valide."
        ];

        $this->validate($request,
            [
                "title" => ["required"],
                "content" => ["required"],
                "datePublication" => ["required", "date"],
                "position" => ["required"]
            ],$messages);

        $input = $request->only(["title", "content", "datePublication","position"]);
        if($input["position"] == "null"){
            $position = -1;
        }
        else{
            $position = intval($input["position"],10);
        }
        DB::table("annonces")->where("id", $id)->update([
            "title" => $input["title"],
            "content" => $input["content"],
            "datePublication" => $input["datePublication"],
            "position" => $position,
        ]);

        return redirect(route('accueil'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posMax = Annonces::orderBy('position', 'desc')->value('position');
        if (Auth::check()) {
            foreach (Auth::user()->roles as $role) {
                if ($role->typeRole == "ADMIN") {
                    return view("annonce/creerUneAnnonce",compact("posMax"));
                }
            }
        }
    }

    function enregistrerUneAnnonce(Request $request)
    {

        $messages = [
            "title.required" => "Veuillez saisir un titre valide.",
            "content.required" => "Veuillez saisir un contenu valide.",
            "datePublication.required" => "Veuillez saisir une date valide.",
            "datePublication.date" => "Veuillez saisir une date valide.",
            "position.required" => "Veuillez saisir une position valide."
        ];

        $this->validate($request,
            [
                "title" => ["required"],
                "content" => ["required"],
                "datePublication" => ["required", "date"],
                "position" => ["required"]
            ],$messages);

        $input = $request->only(["title", "content", "datePublication","position"]);
        if($input["position"] == "null"){
            $position = -1;
        }
        else{
            $position = intval($input["position"],10);
        }
        DB::table("annonces")->insert([
            "title" => $input["title"],
            "content" => $input["content"],
            "datePublication" => $input["datePublication"],
            "position" => $position,
        ]);

        return redirect(route('accueil'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Annonces $annonces
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        foreach (Auth::user()->roles as $role) {
            if ($role->typeRole == 'ADMIN') {
                DB::delete('delete from annonces where id = ?', [$id]);
            }
        }
        return redirect(route('accueil'));
    }
}
