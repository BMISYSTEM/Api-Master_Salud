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
        Schema::table('users', function (Blueprint $table) {
            // Agregar una nueva columna
            $table->integer('rol')->nullable();
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->integer('cedula')->nullable();
            $table->integer('fijo')->nullable();
            $table->integer('celular')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar la columna agregada en la migración anterior
            $table->dropColumn('rol');
            $table->dropColumn('nombre');
            $table->dropColumn('apellido');
            $table->dropColumn('cedula');
            $table->dropColumn('fijo');
            $table->dropColumn('celular');
        });
    }
};
