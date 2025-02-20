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
        Schema::create('obra_impuestos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fecha_conclusion')->nullable();
            $table->date('fecha_reembolso')->nullable();
            $table->unsignedBigInteger('responsable');
            $table->json('unidades_gestion')->nullable();
            $table->json('centros_operacion')->nullable();
            $table->unsignedBigInteger('id_empresa');
            // llave foranea
            
            $table->foreignId('tipo_id')->constrained('tipo_estado_atencions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obra_impuestos');
    }
};
