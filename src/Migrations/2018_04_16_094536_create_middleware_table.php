<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiddlewareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('middlewares', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name')->default('');
			$table->integer('route_id')->default('0');
            $table->timestamps();
            $table->index('name');
	        $table->index('route_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('middleware');
    }
}
