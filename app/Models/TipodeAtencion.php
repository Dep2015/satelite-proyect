<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipodeAtencion extends Model
{
    protected $fillable = [
        'name',
        'id_empresa',
    ];

    public function estadoatencion() {
        return $this->hasMany(EstadoAtencion::class,'tipo_id');
    }
}
