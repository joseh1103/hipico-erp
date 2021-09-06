<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subasta extends Model
{
    protected $table = 'subasta';

    public function jornada() {
        return $this->hasOne('App\Jornada', 'id', 'jornada_id');
    }

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function carrera() {
        return $this->hasOne('App\Carrera', 'id', 'carrera_id');
    }
}
