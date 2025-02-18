<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEstadoAtencion extends Model
{
    protected $fillable = [
        'name',
        'id_empresa',
    ];
}
