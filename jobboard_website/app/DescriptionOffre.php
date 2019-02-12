<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescriptionOffre extends Model
{
    protected $table = "description_offre";

    public function offre(){
        return $this->belongsTo("App\Offre", 'idOffre');
    }
}
