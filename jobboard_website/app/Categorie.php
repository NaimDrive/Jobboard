<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'categorie';

    public function competences() {
        return $this->belongsTo('App\CompetencesEtudiant' , 'idCompEtu');
    }
}
