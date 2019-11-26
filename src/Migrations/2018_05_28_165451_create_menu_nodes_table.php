<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_nodes', function (Blueprint $table) {
	        // These columns are needed for Baum's Nested Set implementation to work.
	        // Column names may be changed, but they *must* all exist and be modified
	        // in the model.
	        // Take a look at the model scaffold comments for details.
	        // We add indexes on parent_id, lft, rgt columns by default.
	        $table->increments('id');
	        $table->integer('parent_id')->nullable()->index();
	        $table->integer('left')->nullable()->index();
	        $table->integer('right')->nullable()->index();
	        $table->integer('depth')->nullable();

	        // Add needed columns here (f.ex: name, slug, path, etc.)
	        $table->string('name', 255);
	        $table->string('route', 255)->default('');;
	        $table->integer('menu_id')->default('0');;
	        $table->string('menu_icon','191')->default('fas fa-home');;
	        $table->integer('menu_pos')->default('0');;
	        $table->unique(['name','menu_id']);

	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_nodes');
    }
}
