<?php
namespace dvplex\Phantom\Seeds;
use dvplex\Phantom\Modules\MenuNodes\Entities\MenuNode;
use dvplex\Phantom\Modules\Menus\Entities\Menu;
use Illuminate\Database\Seeder;
class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Menu::firstOrCreate([
		    'name' => 'main_menu',
	    ]);

        MenuNode::firstOrCreate([
            'name' => 'Dashboard',
            'left' => 1,
            'right' => 2,
            'route' => 'phantom.modules.admin@index',
            'menu_icon' => 'fas fa-home',
            'menu_pos' => 0,
        ]);
    }
}
