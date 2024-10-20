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
        Schema::create('venta_productos', function (Blueprint $table) {
            $table->id();
            $table->uuid('factura');
            $table->unsignedBigInteger('producto');
            $table->unsignedBigInteger('promocion');
            $table->unsignedBigInteger('marca');
            $table->float('valor_unitario');
            $table->float('procentaje_aplicado');
            $table->foreign('factura')->references('factura')->on('ventas');
            $table->foreign('producto')->references('id')->on('productos');
            $table->foreign('promocion')->references('id')->on('promociones');
            $table->foreign('marca')->references('id')->on('marcas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_productos');
    }
};
