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
        Schema::create('actividades_ejecucions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secuencia_id');
            $table->string('name');
            $table->date('fecha')->nullable();
            $table->text('comentarios');
            $table->json('responsables')->nullable();
            $table->unsignedBigInteger('id_empresa');
            $table->timestamps();

            // Llaves foráneas
            $table->foreignId('atencion_estado_id')->constrained('atencion_estados')->onDelete('cascade');
           // $table->foreignId('tipo_estado_ejecucion_id')->constrained('estado_etapa_ejecucions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades_ejecucions');
    }
};
