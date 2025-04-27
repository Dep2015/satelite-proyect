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
        Schema::table('tipo_estado_atencions', function (Blueprint $table) {
            $table->tinyInteger('estado')->default(1)->after('id_empresa');
            // Se crea el campo 'estado' después de 'id_empresa'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipo_estado_atencions', function (Blueprint $table) {
            //
        });
    }
};
