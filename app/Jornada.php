<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    protected $table = 'jornadas';

    public function carreras(){
        return $this->hasMany(Carrera::class);
    }

    public function hipodromo() {
        return $this->hasOne('App\Hipodromo', 'id', 'hipodromo_id');
    }
}
