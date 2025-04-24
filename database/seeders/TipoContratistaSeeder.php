<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoContratista;

class TipoContratistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoContratista::create([
            'name' => 'Infraestructura',
            'id_empresa' => 1,
    ]);

    TipoContratista::create([
        'name' => 'Sobre Experiencia del Ejecutor',
        'id_empresa' => 1,
    ]);


    TipoContratista::create([
        'name' => 'Sobre Experiencia de los Profesionales',
        'id_empresa' => 1,
    ]);

    }
}
