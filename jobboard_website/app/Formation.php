<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $table = 'formation';

    public function etudiant() {
        return $this->belongsTo('App\Etudiant', 'idEtudiant');
    }
}
