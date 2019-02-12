<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CentreDInteret extends Model
{
    protected $table = "centre_d_interet";

    public function etudiant() {
        return $this->belongsTo('App\Etudiant', 'idEtudiant');
    }
}
