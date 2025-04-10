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
        Schema::create('archivoss32s', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_original');
            $table->string('path');
            $table->integer('tipo'); // 'imagenes' o 'documentos'
            $table->integer('categoria');
            $table->integer('codigo_registro');
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivoss32s');
    }
};
