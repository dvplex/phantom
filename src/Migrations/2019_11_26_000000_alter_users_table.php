<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
            $table->string('username')->nullable();
	        $table->string('user_avatar')->default('user.png');
	        $table->dateTime('deleted_at')->nullable();
            $table->rememberToken();
			$table->string('api_token', 80)->after('password')
				->unique()
				->nullable()
				->default(null);
            $table->unique(['username','deleted_at']);
            $table->unique(['email','deleted_at']);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('users');
            $table->dropColumn('deleted_at');
        });
	}
}
