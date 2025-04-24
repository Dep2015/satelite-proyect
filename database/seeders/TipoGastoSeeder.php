<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoGasto;

class TipoGastoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        TipoGasto::create([
            'name' => 'Administrativo',
            'id_empresa' => 1,
    ]);


    TipoGasto::create([
        'name' => 'Reembolsable',
        'id_empresa' => 1,
]);


    }
}
