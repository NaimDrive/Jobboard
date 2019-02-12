<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recherche extends Model
{
    protected $table = "recherche";

    public function etudiant() {
        return $this->belongsTo('App\Etudiant', 'idEtudiant');
    }
}
