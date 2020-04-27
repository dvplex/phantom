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
			$table->integer('route_id')->nullable()->unsigned();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
            $table->index('deleted_at');
            $table->index('name');
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');
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
