<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoEtapaEjecucion;

class EstadoEtapaEjecucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EstadoEtapaEjecucion::create([
            'name' => 'INICIO',
        ]);

        EstadoEtapaEjecucion::create([
            'name' => 'EN EJECUCION',
        ]);

        EstadoEtapaEjecucion::create([
            'name' => 'FINALIZADO',
        ]);
    }
}
