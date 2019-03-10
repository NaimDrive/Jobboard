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
        $annonces = Annonces::all();
        return view('annonce/afficherLesAnnonces', compact('annonces'));
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
                    return view('annonce/modifierUneAnnonce', ['annonce' => $annonce]);
                }
                return redirect(route('accueil'));
            }
        }
        return redirect(route('login'));
    }

    function enregistrerModifAnnonce(Request $request, $id)
    {
        $this->validate($request,
            [
                "title" => ["required"],
                "content" => ["required"],
                "datePublication" => ["required", "date"]
            ]);

        $input = $request->only(["title", "content", "datePublication"]);
        DB::table("annonces")->where("id", $id)->update([
            "title" => $input["title"],
            "content" => $input["content"],
            "datePublication" => $input["datePublication"],
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
        if (Auth::check()) {
            foreach (Auth::user()->roles as $role) {
                if ($role->typeRole == "ADMIN") {
                    return view("annonce/creerUneAnnonce");
                }
            }
        }
    }

    function enregistrerUneAnnonce(Request $request)
    {

        $this->validate($request,
            [
                "title" => ["required"],
                "content" => ["required"],
                "datePublication" => ["required", "date"]
            ]);

        $input = $request->only(["title", "content", "datePublication"]);
        DB::table("annonces")->insert([
            "title" => $input["title"],
            "content" => $input["content"],
            "datePublication" => $input["datePublication"],
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
