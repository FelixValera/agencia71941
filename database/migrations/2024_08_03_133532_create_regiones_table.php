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
        Schema::create('regiones', function (Blueprint $table) {
            //$table->id(); id int pk auto_increment no null
            //$table->timestamps(); crea dos columnas update_at y create_at

            $table->tinyIncrements('idRegion'); //crea la columna 'idRegion' pk not null 

            $table->string('nombre',45)->unique(); //crea una columna varchar(45) con restriccion unico 
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regiones');
    }
};
