<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('points')->nullable();
            $table->enum('type_of_file', ['picture','video','both']);
            $table->boolean('editable')->default(false);
            $table -> foreignId('sessiongame_id')->constrained('sessiongames')->onDelete('cascade');
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
        Schema::dropIfExists('challenges');
    }
}
