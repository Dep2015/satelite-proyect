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
        Schema::create('atencion_estados', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color');
            $table->string('irechazo');
            $table->string('iavance');
            $table->longText('descripcion');
            $table->unsignedBigInteger('id_empresa');
            $table->json('actividades')->nullable();

            // Llaves foráneas
            $table->foreignId('accion_id')->constrained('accion_estado_atencions')->onDelete('cascade');
            $table->foreignId('tipo_id')->constrained('tipode_atencions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atencion_estados');
    }
};
