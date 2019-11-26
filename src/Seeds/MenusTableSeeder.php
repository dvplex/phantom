<?php
namespace dvplex\Phantom\Seeds;
use dvplex\Phantom\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu')->insert([
            'name' => 'main_menu',
        ]);

        DB::table('menu_nodes')->insert([
            'name' => 'Dashboard',
            'left' => 1,
            'right' => 2,
            'route' => 'phantom.modules.admin@index',
            'menu_icon' => 'fas fa-home',
            'menu_pos' => 0,
        ]);
    }
}
