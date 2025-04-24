<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoFinancista;

class TipoFinancistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoFinancista::create([
            'name' => 'Requisito Legal',
            'id_empresa' => 1,
    ]);

    TipoFinancista::create([
        'name' => 'Informacion Financiera',
        'id_empresa' => 1,
]);

    }
}
