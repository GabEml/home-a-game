<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goodies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_path');
            if(env('NEW_PROJECT_PROBLEM') == false) {
                $table->engine = 'InnoDB';
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goodies');
    }
}
