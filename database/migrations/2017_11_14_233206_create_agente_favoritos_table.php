<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenteFavoritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agente_favoritos', function (Blueprint $table) {
            $table->increments('idf');
            $table->string('nombre');
            $table->string('direccion');
            $table->float('lat');
            $table->float('lng');
            $table->string('tipo');
            $table->string('sistema');
            $table->string('seguridad');
            $table->string('descripcion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agente_favoritos');
        
    }
}
