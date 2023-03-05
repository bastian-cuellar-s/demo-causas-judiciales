<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateDeligenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deligencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('abogado_id');
            $table->unsignedBigInteger('demandado_id');
            $table->string('rol');
            $table->string('tribunal');
            $table->string('materia');
            $table->string('caratulado');
            $table->mediumText('obs')->nullable();
            //$table->string('encargo');
            //$table->string('cuaderno');
            //$table->boolean('estampe')->nullable();
            //$table->boolean('correo')->nullable();
            //$table->boolean('cobrado')->nullable();
            //$table->boolean('pagado')->nullable();
            //$table->date('f_estampado')->nullable();
            //$table->date('f_resolucion')->nullable();
            //$table->longText('resultado')->nullable();
            $table->timestamps();

            $table->foreign('cliente_id')
            ->references('id')
            ->on('personas');

            $table->foreign('abogado_id')
            ->references('id')
            ->on('personas');

            $table->foreign('demandado_id')
            ->references('id')
            ->on('personas');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deligencias');
    }
}
