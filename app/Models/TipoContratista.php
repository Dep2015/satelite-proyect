<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoContratista extends Model
{
    protected $fillable = [
        'name',
        'id_empresa',
    ];


    public function informacionContratista() {
        return $this->hasMany(InformacionContratista::class,'id_tipo_contratista');
    }
}
