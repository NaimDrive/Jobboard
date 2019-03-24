<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtudiantParticipe extends Model
{
    function etudiant(){
        return $this->belongsTo('App\Etudiant','idEtudiant');
    }
}
