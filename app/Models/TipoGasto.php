<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoGasto extends Model
{
    protected $fillable = [
        'name',
        'id_empresa',
    ];


    public function pagosOI() {
        return $this->hasMany(PagosOI::class,'id_tipo_gasto');
    }


}
