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
            $table->string('route')->default('');
            $table->integer('module_id')->default('0');
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
            $table->index('deleted_at');
            $table->index('module_id');
	        $table->index('httpMethod');
	        $table->index('controllerMethod');
	        $table->unique(['httpMethod','controllerMethod','module_id','deleted_at']);
            $table->unique(['route', 'deleted_at']);
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
