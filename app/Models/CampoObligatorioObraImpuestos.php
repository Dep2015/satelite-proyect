<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampoObligatorioObraImpuestos extends Model
{
    protected $fillable = [
        'name',
        'habilitardeshabilitar',
        'obligatorio',
        'id_empresa',
    ];
}
