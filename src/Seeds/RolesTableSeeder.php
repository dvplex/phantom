<?php
namespace dvplex\Phantom\Seeds;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('roles')->insert([
		    'name' => 'Administrator',
		    'guard_name' => 'web',
	    ]);

	    DB::table('model_has_roles')->insert([
		    'role_id' => 1,
		    'model_id' => 1,
		    'model_type' => 'dvplex\\Phantom\\Models\\User',
	    ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_id' => 1,
            'model_type' => 'dvplex\\Phantom\\Modules\\Menus\\Entities\\Menu',
        ]);
    }
}
