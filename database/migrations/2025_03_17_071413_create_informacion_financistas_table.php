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
        Schema::create('informacion_financistas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_tipo_financista')->constrained('tipo_financistas')->onDelete('cascade');

            $table->string('aspecto');
            $table->text('comentarios');
            $table->json('id_categoria_documento')->nullable();
            $table->json('responsables')->nullable();
            $table->unsignedBigInteger('id_empresa');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_financistas');
    }
};
