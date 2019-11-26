<?php

namespace dvplex\Phantom\Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::table('roles')->insert([
            'name' => 'Administrator',
            'guard_name' => 'web',
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_id' => 1,
            'model_type' => 'dvplex\\Phantom\\Models\\User',
        ]);

        // $this->call("OthersTableSeeder");
    }
}
