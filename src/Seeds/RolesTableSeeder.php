<?php
namespace dvplex\Phantom\Seeds;
use dvplex\Phantom\Models\Role;
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
        Role::firstOrCreate([
            'name' => 'Administrator',
            'guard_name' => 'web',
        ]);
       $model =  DB::table('model_has_roles')->select('role_id')->whereRaw("role_id=1 and model_id=1 and model_type='dvplex\\Phantom\\Models\\User'");
        if ($model->count() <= 0) {
            DB::table('model_has_roles')->insert([
                'role_id' => 1,
                'model_id' => 1,
                'model_type' => 'dvplex\\Phantom\\Models\\User',
            ]);
        }
    }
}
