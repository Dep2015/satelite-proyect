<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoEstadoAtencion;

class TipoEstadoAtencionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        TipoEstadoAtencion::create([
            'name' => 'Proyectos de Prueba',
            'id_empresa' => 1,
    ]);

        TipoEstadoAtencion::create([
            'name' => 'Proyectos de Inversión',
            'id_empresa' => 1,
    ]);

    TipoEstadoAtencion::create([
        'name' => 'IOARR',
        'id_empresa' => 1,
]);

TipoEstadoAtencion::create([
    'name' => 'IOARR de Emergencia',
    'id_empresa' => 1,
]);


TipoEstadoAtencion::create([
    'name' => 'Operación',
    'id_empresa' => 1,
]);


    }
}
