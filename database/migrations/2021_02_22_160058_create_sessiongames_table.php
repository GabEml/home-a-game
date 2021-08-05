<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessiongamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessiongames', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('price')->default(40.00);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('image_path');
            $table -> foreignId('goodie_id')->nullable()->constrained('goodies')->onDelete('set null');
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessiongames');
    }
}
