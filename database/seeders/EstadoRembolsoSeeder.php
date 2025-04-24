<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoRembolso;

class EstadoRembolsoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EstadoRembolso::create([
            'name' => 'EstadoRembolso',

    ]);

    EstadoRembolso::create([
            'name' => 'No Reembolsado',

    ]);

    }
}
