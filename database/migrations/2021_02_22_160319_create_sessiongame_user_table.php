<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessiongameUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessiongame_user', function (Blueprint $table) {
            $table->id();
            $table -> foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table -> foreignId('sessiongame_id')->nullable()->constrained('sessiongames')->onDelete('set null');

            $table -> unique(['sessiongame_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessiongame_user');
    }
}
