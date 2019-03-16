<?php
/**
 * Created by PhpStorm.
 * User: bastienlaffon
 * Date: 11/02/2019
 * Time: 15:28
 */

namespace App\Http\Controllers;


use App\Forum;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;

class AccueilController
{
    public function index()
    {
        $dateNow = Date::now();
        $forums = Forum::query()->get();
        $annonces = DB::table('annonces')->orderBy("position")->get();
        return view('accueil', ['annonces'=>$annonces, 'forums'=>$forums, 'dateNow' => $dateNow]);
    }
}
