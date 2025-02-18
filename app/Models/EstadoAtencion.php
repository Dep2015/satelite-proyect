<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoAtencion extends Model
{
    protected $fillable = [
        'name',
        'color',
       'irechazo',
        'iavance',
        'accion_id',
        'tipo_id',
        'descripcion',
        'id_empresa',
    ];

    public function accionestado() {
        
        return $this->belongsTo(AccionEstadoAtencion::class, 'accion_id');
    }

    public function acciontipoatencion() {
        return $this->belongsTo(TipodeAtencion::class,'tipo_id');
    }
}
