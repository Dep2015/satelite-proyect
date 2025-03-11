<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccionEstadoAtencion extends Model
{
    protected $fillable = [
        'name',
        'id_empresa',
    ];


    public function estadoatencionv1() {
        return $this->hasMany(AtencionEstados::class,'accion_id');
    }
}
