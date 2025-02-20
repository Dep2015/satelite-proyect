<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObraImpuestos extends Model
{
    protected $fillable = [
           'nombre',
            'fecha_conclusion',
            'fecha_reembolso',
            'responsable',
            'unidades_gestion',
            'centros_operacion',
            'id_empresa',
            'tipo_id',
        ];

        public function tipo() {
            
            return $this->belongsTo(TipoEstadoAtencion::class, 'tipo_id');
        }
}
