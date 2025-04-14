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
        Schema::create('actividades_estado_atencion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_estado_atencion');
            $table->integer('secuencia');
            $table->string('nombre');

            $table->foreign('id_estado_atencion')
                ->references('id')->on('atencion_estados')
                ->onDelete('cascade'); // Elimina las actividades si se borra el estado

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades_estado_atencion');
    }
};
