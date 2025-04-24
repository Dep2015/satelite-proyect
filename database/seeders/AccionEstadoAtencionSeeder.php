<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccionEstadoAtencion;

class AccionEstadoAtencionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        AccionEstadoAtencion::create([
            'name' => 'Visto Bueno',
            'id_empresa' => 1,
        ]);

    }
}
