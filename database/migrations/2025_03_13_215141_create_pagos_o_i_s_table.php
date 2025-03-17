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
        Schema::create('pagos_o_i_s', function (Blueprint $table) {
            $table->id();
            $table->json('beneficiario')->nullable();
            $table->json('grupo_interes')->nullable();
            $table->json('responsables')->nullable();
            $table->date('fecha')->nullable();
            $table->decimal('monto_pagado', 15, 4);
            $table->unsignedBigInteger('id_empresa');


            $table->foreignId('id_tipo_gasto')->constrained('tipo_gastos')->onDelete('cascade');

            $table->foreignId('id_estado_rembolso')->constrained('estado_rembolsos')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_o_i_s');
    }
};
