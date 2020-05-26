<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHttpMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('http_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',191);
	        $table->integer('route_id')->nullable()->unsigned();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
            $table->index('deleted_at');
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
        Schema::dropIfExists('http_methods');
    }
}
