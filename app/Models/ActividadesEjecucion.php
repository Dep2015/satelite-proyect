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
        'responsables',
        'atencion_estado_id',
        'tipo_estado_ejecucion_id',
        'id_obra_impuesto',


    ];

    protected $casts = [
        'responsables' => 'array',
    ];

    public function atencion_estado() {

        return $this->belongsTo(AtencionEstados::class, 'atencion_estado_id');
    }

    public function tipo_estado_etapa_ejecucion() {

        return $this->belongsTo(EstadoEtapaEjecucion::class, 'tipo_estado_ejecucion_id');
    }
}
