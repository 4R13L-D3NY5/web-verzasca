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
        Schema::create('traspasos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('existencia_origen_id')->constrained('existencias')->onDelete('cascade');
            $table->foreignId('existencia_destino_id')->nullable()->constrained('existencias')->nullOnDelete();
            $table->foreignId('personal_id')->constrained('personals')->onDelete('cascade');
            $table->integer('cantidad');
            $table->date('fecha_traspaso');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traspasos');
    }
};
