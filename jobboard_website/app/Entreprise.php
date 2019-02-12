<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $table = 'entreprise';

    public function contacts() {
        return $this->hasMany('App\ContactEntreprise', 'idEntreprise');
    }

    public function adress() {
        return $this->hasMany('App\AdressEntreprise', 'idEntreprise');
    }
}
