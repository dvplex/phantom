<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('menus', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->default('');
            $table->tinyInteger('type')->default('0');
			$table->text('description');
            $table->dateTime('deleted_at')->nullable();
            $table->index('deleted_at');
			$table->index('name');
            $table->index('type');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('menus');
	}

}
