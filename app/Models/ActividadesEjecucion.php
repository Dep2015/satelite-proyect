<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActividadesEjecucion extends Model
{
    protected $fillable = [

        'secuencia_id',
        'name',
        'fecha',
        'comentarios',
        'id_empresa',
        'atencion_estado_id',
        'tipo_estado_ejecucion_id',


    ];

    protected $casts = [
        'responsable' => 'array',
    ];

    public function atencion_estado() {

        return $this->belongsTo(AccionEstadoAtencion::class, 'atencion_estado_id');
    }

    public function tipo_estado_etapa_ejecucion() {

        return $this->belongsTo(AccionEstadoAtencion::class, 'tipo_estado_ejecucion_id');
    }
}
