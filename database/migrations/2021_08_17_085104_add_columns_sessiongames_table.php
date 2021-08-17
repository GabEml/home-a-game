<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsSessiongamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sessiongames', function (Blueprint $table) {
            $table->enum('type', ['On The Road a Game','Home a Game']);
            $table->boolean('see_ranking')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sessiongames', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('see_ranking');
        });
    }
}
