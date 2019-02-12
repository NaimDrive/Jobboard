<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = "experience";

    public function etudiant() {
        return $this->belongsTo('App\Etudiant', 'idEtudiant');
    }
}
