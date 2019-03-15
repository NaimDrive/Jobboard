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

    public function offres(){
        return $this->hasMany('App\Offre','idEntreprise');
    }

    public function getCreateur() {
        return $this->belongsTo('App\ContactEntreprise', 'createur');
    }

    public function forums(){
        return $this->belongsToMany("App\Forum",'entreprise_participes','idEntreprise','idForum');
    }
}
