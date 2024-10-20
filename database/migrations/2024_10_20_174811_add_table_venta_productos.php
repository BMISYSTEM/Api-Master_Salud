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
        Schema::table('venta_productos', function (Blueprint $table) {
            // Agregar una nueva columna
            $table->integer('cantidad')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venta_productos', function (Blueprint $table) {
            // Eliminar la columna agregada en la migración anterior
            $table->dropColumn('cantidad');
        });
    }
};
