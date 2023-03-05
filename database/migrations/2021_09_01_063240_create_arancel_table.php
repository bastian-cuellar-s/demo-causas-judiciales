<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArancelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aranceles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('g_arancel_id');
            $table->string('name');
            $table->integer('valor');
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
        Schema::dropIfExists('aranceles');
    }
}
