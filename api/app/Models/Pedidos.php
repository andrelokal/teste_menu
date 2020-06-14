<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'status',
        'id_cliente',
        'valor',
        'created_at',
        'updated_at'
    ];
}
