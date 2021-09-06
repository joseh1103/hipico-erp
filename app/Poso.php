<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poso extends Model
{
    protected $table = 'poso';

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
