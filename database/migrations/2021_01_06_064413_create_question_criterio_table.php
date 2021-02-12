<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionCriterioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_criterio', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('criterio_id');
            $table->float('score');

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('criterio_id')->references('id')->on('criterios')->onDelete('cascade');

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
        Schema::dropIfExists('question_criterio');
    }
}
