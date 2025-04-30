<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObraporImpuesto extends Model
{
    protected $fillable = [
        'nombre',
         'fecha_conclusion',
         'fecha_reembolso',
         'costo_proyecto',
         'responsable',
         'unidades_gestion',
         'centros_operacion',
         'id_empresa',
         'tipo_id',
         'estado_id',
         'estado',
     ];


     protected $casts = [
        'responsable' => 'array',
        'unidades_gestion' => 'array',
        'centros_operacion' => 'array',
    ];


     public function tipo() {

         return $this->belongsTo(TipoEstadoAtencion::class, 'tipo_id');
     }


     public function estado() {

        return $this->belongsTo(AtencionEstados::class, 'estado_id');
    }

    public function estados() {

        return $this->belongsTo(AtencionEstados::class, 'estado_id');
    }

    public function pagos()
{
    return $this->hasMany(PagosOI::class, 'id_obra_impuesto');
}

public function pagosTipoGasto1()
{
    return $this->hasMany(PagosOI::class, 'id_obra_impuesto')
                ->where('id_tipo_gasto', 1);
}

}
