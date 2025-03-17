<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformacionContratista extends Model
{

    protected $fillable = [
        'id_tipo_contratista',
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


        public function tipocontratista() {

            return $this->belongsTo(TipoContratista::class, 'id_tipo_contratista');
        }
}
