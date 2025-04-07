<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformacionFinancista extends Model
{
    protected $fillable = [

    'id_tipo_financista',
    'aspecto',
    'comentarios',
    'id_categoria_documento',
    'responsables',
    'id_empresa',
    ];


    protected $casts = [
            'id_categoria_documento' => 'array',
            'responsables' => 'array',
    ];


    public function tipoFinancista() {

        return $this->belongsTo(TipoFinancista::class, 'id_tipo_financista');
    }
}
