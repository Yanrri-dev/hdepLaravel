<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObtieneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obtiene', function (Blueprint $table) {
            $table->id();

            $table->float('score_obtenido');
            $table->float('porcentaje');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('criterio_id');
            $table->unsignedBigInteger('question_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('criterio_id')->references('id')->on('criterios')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');

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
        Schema::dropIfExists('obtiene');
    }
}
