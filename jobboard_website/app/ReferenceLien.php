<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenceLien extends Model
{
    protected $table = 'reference_lien';

    public function etudiant() {
        return $this->belongsTo('App\Etudiant', 'idEtudiant');
    }
}
