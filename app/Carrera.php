<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carreras';
    protected $fillable = ['jornada_id', 'carrera'];

    public function jornada() {
        return $this->hasOne('App\Jornada', 'id', 'jornada_id');
    }
}
