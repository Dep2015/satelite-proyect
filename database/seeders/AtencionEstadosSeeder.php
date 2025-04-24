<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AtencionEstados;

class AtencionEstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            [
                'id' => 1,
                'name' => 'Priorización',
                'color' => '#c5cbc3',
                'irechazo' => 'Retroceder',
                'iavance' => 'Avanzar',
                'descripcion' => 'Estado inicial de atención',
                'id_empresa' => 1,
                'actividades' => [],
                'accion_id' => 1,
                'tipo_id' => 2,

            ],
            [
                'id' => 2,
                'name' => 'Actos Previos',
                'color' => '#7ec0f4',
                'irechazo' => 'Retroceder',
                'iavance' => 'Avanzar',
                'descripcion' => 'Sin definir',
                'id_empresa' => 1,
                'actividades' => [],
                'accion_id' => 1,
                'tipo_id' => 1,

            ],
            [
                'id' => 3,
                'name' => 'Selección',
                'color' => '#2196f3',
                'irechazo' => 'Retroceder',
                'iavance' => 'Avanzar',
                'descripcion' => 'Sin definir',
                'id_empresa' => 1,
                'actividades' => [],
                'accion_id' => 1,
                'tipo_id' => 1,

            ],
            [
                'id' => 4,
                'name' => 'Ejecucción',
                'color' => '#1f7cc5',
                'irechazo' => 'Retroceder',
                'iavance' => 'Avanzar',
                'descripcion' => 'Sin definir',
                'id_empresa' => 1,
                'actividades' => [],
                'accion_id' => 1,
                'tipo_id' => 1,

            ],
            [
                'id' => 5,
                'name' => 'Emisión de CIPRL o CIPGN',
                'color' => '#084379',
                'irechazo' => 'Retroceder',
                'iavance' => 'Avanzar',
                'descripcion' => 'Sin definir',
                'id_empresa' => 1,
                'actividades' => [],
                'accion_id' => 1,
                'tipo_id' => 1,

            ],
        ];

        foreach ($estados as $estado) {
            AtencionEstados::updateOrCreate(['id' => $estado['id']], $estado);
        }
    }
}
