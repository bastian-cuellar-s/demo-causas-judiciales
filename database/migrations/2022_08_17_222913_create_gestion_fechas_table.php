<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestionFechasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestion_fechas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gestion_id');
            $table->string('name');
            $table->date('fecha')->nullable();
            $table->timestamps();

            $table->foreign('gestion_id')
            ->references('id')
            ->on('gestiones')
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
        Schema::dropIfExists('gestion_fechas');
    }
}
