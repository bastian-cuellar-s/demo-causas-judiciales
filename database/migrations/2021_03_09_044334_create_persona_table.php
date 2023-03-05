<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->unsignedBigInteger('g_arancel_id')->nullable();
            $table->string('name');
            $table->string('APaterno')->nullable();
            $table->string('AMaterno')->nullable();
            $table->string('rut')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('telefono')->unique()->nullable();
            $table->mediumText('obs')->nullable();
            $table->string('tipo_persona');
            $table->string('funcion');
            $table->string('representante')->nullable();
            $table->timestamps();

            $table->foreign('g_arancel_id')
            ->references('id')
            ->on('grupo_aranceles')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
