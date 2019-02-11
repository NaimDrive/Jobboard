<?php
/**
 * Created by PhpStorm.
 * User: bastienlaffon
 * Date: 11/02/2019
 * Time: 15:28
 */

namespace App\Http\Controllers;


class AccueilController
{
    public function index()
    {
        return view('accueil');
    }
}