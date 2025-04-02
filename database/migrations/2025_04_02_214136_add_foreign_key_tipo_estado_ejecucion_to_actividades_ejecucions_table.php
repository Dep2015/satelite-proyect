<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('actividades_ejecucions', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_estado_ejecucion_id'); // o quita nullable si es obligatorio

            $table->foreign('tipo_estado_ejecucion_id')
                  ->references('id')
                  ->on('estado_etapa_ejecucions')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actividades_ejecucions', function (Blueprint $table) {
            //
        });
    }
};
