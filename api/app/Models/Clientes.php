<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'sobrenome',
        'email',
        'created_at',
        'updated_at'
    ];
}
