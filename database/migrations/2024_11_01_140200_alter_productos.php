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
        Schema::table('motivos_consultas', function (Blueprint $table) {
            $table->unsignedBigInteger('caracteristica')->nullable();
            $table->foreign('caracteristica')->references('id')->on('caracteristicas');
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
