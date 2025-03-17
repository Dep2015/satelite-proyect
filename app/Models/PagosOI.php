<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagosOI extends Model
{

    protected $fillable = [
            'beneficiario',
            'grupo_interes',
            'fecha',
            'monto_pagado',
            'id_tipo_gasto',
            'id_estado_rembolso',
            'responsables',
            'id_empresa',

        ];


        protected $casts = [
           'beneficiario' => 'array',
           'grupo_interes' => 'array',
           'responsables' => 'array',
       ];


       public function tipoGasto() {

        return $this->belongsTo(TipoGasto::class, 'id_tipo_gasto');
    }

    public function estadoReembolso() {

        return $this->belongsTo(EstadoRembolso::class, 'id_estado_rembolso');
    }

}
