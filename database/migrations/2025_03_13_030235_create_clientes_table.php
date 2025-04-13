<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre del cliente
            $table->string('empresa')->nullable(); // Empresa del cliente (opcional)
            $table->string('nitCi')->unique()->nullable(); // NIT/CI único
            $table->string('razonSocial')->nullable(); // Razón social
            $table->string('celular', 50)->nullable(); // Teléfono
            $table->string('telefono', 50)->nullable(); // Teléfono
            $table->string('correo')->nullable(); // Correo electrónico único
            $table->tinyInteger('categoria')->default(1); // 1) normal, 2) regular, 3) antiguo o frecuente

            $table->decimal('latitud', 10, 8)->nullable(); // Latitud (10 dígitos, 8 decimales)
            $table->decimal('longitud', 11, 8)->nullable(); // Longitud (11 dígitos, 8 decimales)

            // Campo para foto
            $table->string('foto')->nullable(); // Ruta o URL de la foto (opcional)

            $table->boolean('estado')->default(1); // Estado (1: activo, 0: inactivo)
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
