<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balance_general';

    protected $primaryKey = 'id';
    protected $fillable = ['poso_id', 'user_id', 'subastas_id'];
}
