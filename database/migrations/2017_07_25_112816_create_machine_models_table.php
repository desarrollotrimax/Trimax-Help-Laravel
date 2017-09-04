<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachineModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machine_models', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('model', 45)->unique();

            $table->smallInteger('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('machine_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machine_models');
    }
}
