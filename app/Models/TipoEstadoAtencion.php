<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEstadoAtencion extends Model
{
    protected $fillable = [
        'name',
        'estado',
        'id_empresa',

    ];

    public function obraimpuesto() {
        return $this->hasMany(ObraporImpuesto::class,'tipo_id');
    }
}
