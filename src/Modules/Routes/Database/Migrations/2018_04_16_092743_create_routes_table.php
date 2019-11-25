<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('httpMethod')->default('get');
	        $table->string('controllerMethod')->default('index');
            $table->string('route')->default('')->unique();
            $table->integer('module_id')->default('0');
            $table->timestamps();
            $table->index('module_id');
	        $table->index('httpMethod');
	        $table->index('controllerMethod');
	        $table->unique(['httpMethod','controllerMethod','module_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routes');
    }
}
