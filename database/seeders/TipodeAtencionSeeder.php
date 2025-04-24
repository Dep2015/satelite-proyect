<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipodeAtencion;

class TipodeAtencionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipodeAtencion::create([
            'name' => 'TIPO 1',
            'id_empresa' => 1,
    ]);

    TipodeAtencion::create([
        'name' => 'TIPO 2',
        'id_empresa' => 1,
    ]);

   TipodeAtencion::create([
    'name' => 'TIPO 3',
    'id_empresa' => 1,
  ]);

  TipodeAtencion::create([
    'name' => 'TIPO 4',
    'id_empresa' => 1,
  ]);

    }
}
