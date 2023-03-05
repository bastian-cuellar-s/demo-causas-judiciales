<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomicilioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domicilios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('persona_id');
            $table->string('direccion');
            $table->integer('numero');
            $table->string('complemento')->nullable();
            $table->string('comuna');
            $table->string('region')->nullable();
            $table->boolean('negativa')->nullable();
            $table->mediumText('obs')->nullable();
            $table->timestamps();

            $table->foreign('persona_id')
            ->references('id')
            ->on('personas')
            ->onDelete('cascade');
        });

        Schema::create('regions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('comunas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id')
            ->references('id')
            ->on('regions')
            ->onDelete('cascade');;
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
        Schema::dropIfExists('domicilios');
        Schema::dropIfExists('comunas');
        Schema::dropIfExists('regions');      
    }
}
