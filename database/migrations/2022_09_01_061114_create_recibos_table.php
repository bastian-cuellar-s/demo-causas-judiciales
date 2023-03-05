<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecibosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('arancel_id');
            $table->unsignedBigInteger('gestion_id');
            $table->unsignedBigInteger('persona_id');
            $table->mediumText('obs')->nullable();
            $table->integer('total');
            $table->string('boleta')->nullable();
            $table->timestamps();

            $table->foreign('arancel_id')
            ->references('id')
            ->on('aranceles')
            ->onDelete('cascade');


            $table->foreign('gestion_id')
            ->references('id')
            ->on('gestiones')
            ->onDelete('cascade');

            $table->foreign('persona_id')
            ->references('id')
            ->on('personas')
            ->onDelete('cascade');

            
        });

        Schema::create('extras_recibo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('recibo_id');
            $table->string('name');
            $table->integer('valor');   
            $table->mediumText('obs')->nullable();   
            $table->timestamps();

            $table->foreign('recibo_id')
            ->references('id')
            ->on('recibos')
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
        Schema::dropIfExists('extras_recibo');
        Schema::dropIfExists('recibos');
        
    }
}
