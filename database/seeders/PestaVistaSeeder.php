<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PestaVista;

class PestaVistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PestaVista::create([
            'name' => 'Nombre de la pestaña',
            'habilitardeshabilitar' => 0,
            'id_empresa' => 1,
    ]);

    PestaVista::create([
        'name' => 'Información Financista',
        'habilitardeshabilitar' => 1,
        'id_empresa' => 1,
    ]);

    PestaVista::create([
        'name' => 'Información Contratista',
        'habilitardeshabilitar' => 1,
        'id_empresa' => 1,
    ]);

    PestaVista::create([
        'name' => 'Pagos',
        'habilitardeshabilitar' => 1,
        'id_empresa' => 1,
    ]);

    PestaVista::create([
        'name' => 'Beneficiarios',
        'habilitardeshabilitar' => 0,
        'id_empresa' => 1,
    ]);

    PestaVista::create([
        'name' => 'Otros Documentos',
        'habilitardeshabilitar' => 0,
        'id_empresa' => 1,
    ]);

    PestaVista::create([
        'name' => 'Etapas y Ejecucion',
        'habilitardeshabilitar' => 0,
        'id_empresa' => 1,
    ]);


    }
}
