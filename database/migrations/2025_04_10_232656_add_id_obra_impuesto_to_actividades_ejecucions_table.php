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
            $table->unsignedBigInteger('id_obra_impuesto')->nullable()->after('id_empresa');
            // Si tenés tabla relacionada:
            // $table->foreign('id_obra_impuesto')->references('id')->on('obras_impuestos')->onDelete('cascade');
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
