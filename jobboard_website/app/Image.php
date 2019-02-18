<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = "image";

    public function etudiant(){
        return $this->belongsTo('App\Etudiant','idEtudiant');
    }
}
