<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestiones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('deligencia_id');
            $table->string('encargo');
            $table->string('cuaderno');
            $table->integer('folio')->nullable();
            $table->integer('deuda')->nullable();
            $table->boolean('estampe')->nullable();
            $table->boolean('correo')->nullable();
            $table->boolean('cobrado')->nullable();
            $table->boolean('pagado')->nullable();
            $table->dateTime('f_notificacion')->nullable();
            $table->date('f_estampado')->nullable();
            $table->longText('resultado')->nullable();
            $table->timestamps();

            $table->foreign('deligencia_id')
            ->references('id')
            ->on('deligencias')
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
        Schema::dropIfExists('gestiones');
    }
}
