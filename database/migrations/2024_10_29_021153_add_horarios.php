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
        Schema::table('horarios', function (Blueprint $table) {
            // Agregar una nueva columna
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->time('lunes');
            $table->time('martes');
            $table->time('miercoles');
            $table->time('jueves');
            $table->time('viernes');
            $table->time('sabado');
            $table->time('domingo');
            $table->unsignedBigInteger('user')->nullable();
            $table->foreign('user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            // Eliminar la columna agregada en la migración anterior
            $table->dropColumn('user');
        });
    }
};
