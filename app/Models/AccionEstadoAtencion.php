<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccionEstadoAtencion extends Model
{
    protected $fillable = [
        'name',
        'id_empresa',
    ];

    public function estadoatencion() {
        return $this->hasMany(EstadoAtencion::class,'accion_id');
    }
}
