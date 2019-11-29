<?php
namespace dvplex\Phantom\Seeds;
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
        DB::table('menus')->insert([
            'name' => 'main_menu',
            'Description' => 'This is the main menu',
        ]);

        DB::table('menu_nodes')->insert([
            'name' => 'Dashboard',
            'left' => 1,
            'menu_id' => 1,
            'right' => 2,
            'route' => 'phantom.modules.admin@index',
            'menu_icon' => 'fas fa-home',
            'menu_pos' => 0,
        ]);
    }
}