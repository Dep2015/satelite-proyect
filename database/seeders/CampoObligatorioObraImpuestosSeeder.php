<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CampoObligatorioObraImpuestos;

class CampoObligatorioObraImpuestosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CampoObligatorioObraImpuestos::create([
                'name' => 'Nombres',
                'habilitardeshabilitar' => 1,
                'obligatorio' => 1,
                'id_empresa' => 1,
        ]);

        CampoObligatorioObraImpuestos::create([
                'name' => 'Fecha de Conclusión',
                'habilitardeshabilitar' => 1,
                'obligatorio' => 1,
                'id_empresa' => 1,
        ]);

        CampoObligatorioObraImpuestos::create([

            'name' => 'Fecha de Reembolso',
            'habilitardeshabilitar' => 1,
            'obligatorio' => 1,
            'id_empresa' => 1,
    ]);


    }
}
