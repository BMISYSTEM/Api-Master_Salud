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
            $table->boolean('lunes')->change();
            $table->boolean('martes')->change();
            $table->boolean('miercoles')->change();
            $table->boolean('jueves')->change();
            $table->boolean('viernes')->change();
            $table->boolean('sabado')->change();
            $table->boolean('domingo')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
