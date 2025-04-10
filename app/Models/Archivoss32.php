<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivoss32 extends Model
{
    protected $fillable = [
        'nombre_original',
        'path',
        'tipo',
        'categoria',
        'codigo_registro',
        'empresa_id',
    ];
}
