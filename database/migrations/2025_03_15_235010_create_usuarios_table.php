<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->string('login')->unique(); // Nombre de usuario único
            $table->string('password'); // Contraseña
            $table->boolean('estado')->default(1); // Estado del usuario (1: activo, 0: inactivo)
            $table->foreignId('rol_id')->constrained('rols'); // Relación con roles
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
