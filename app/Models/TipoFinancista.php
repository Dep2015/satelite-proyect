<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFinancista extends Model
{
    protected $fillable = [
        'name',
        'id_empresa',
    ];


    public function informacionFinancista() {
        return $this->hasMany(InformacionFinancista::class,'id_tipo_financista');
    }

}
