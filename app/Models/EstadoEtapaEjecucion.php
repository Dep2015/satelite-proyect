<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoEtapaEjecucion extends Model
{
    protected $fillable = [
        'name',
    ];

    public function tipo_estado_etapa_ejecucion() {
        return $this->hasMany(ActividadesEjecucion::class,'tipo_estado_ejecucion_id');
    }

}
