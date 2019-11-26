<?php
namespace dvplex\Phantom\Seeds;
use dvplex\Phantom\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::firstOrCreate([
		    'name' => 'admin',
		    'email' => 'admin@example.com',
		    'username' => 'admin',
		    'password' => bcrypt('password'),
	    ]);
    }
}
