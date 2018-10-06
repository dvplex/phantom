<?php

namespace dvplex\Phantom\Commands;

use Illuminate\Console\Command;

class phantom extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'phantom:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initialize phantom files';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	protected function dbsetup() {
		$db = [];
		$db['name'] = $this->ask('Please enter database name:');
		$db['user'] = $this->ask('Please enter username for the database:');
		$db['pass'] = $this->ask('Please enter database password:');

		$this->info('Database name: ' . $db['name']);
		$this->info('Database username: ' . $db['user']);
		$this->info('Database password: ' . $db['pass']);
		if ($this->confirm('Is this info correct?')) {
			shell_exec("sed -i -e 's/DB_DATABASE=.*$/DB_DATABASE={$db['name']}/g' .env");
			shell_exec("sed -i -e 's/DB_USERNAME=.*$/DB_DATABASE={$db['user']}/g' .env");
			shell_exec("sed -i -e 's/DB_PASSWORD=.*$/DB_DATABASE={$db['pass']}/g' .env");
			return true;
		}
		else
			$this->dbsetup();
	}

	public function handle() {
		$key = $this->secret('Please enter secret');
		$platform = trim(shell_exec('uname -s'));
		$this->line('Platform is '.$platform);
		$this->dbsetup();
		if ($platform == 'Linux')
			$r = shell_exec("cp vendor/dvplex/phantom/src/phantom_linux . && ./phantom_linux -i -k {$key} && rm phantom_linux");
		else
			$r = shell_exec("cp vendor/dvplex/phantom/src/phantom . && ./phantom -i -k {$key} && rm phantom");
		if (preg_match('/REG KEY/', $r) || !$key) {
			echo 'Wrong key!';
			exit;
		}
		shell_exec('composer update');
		shell_exec('composer require dvplex/phantom');
		shell_exec('npm install');
		if ($platform == 'Linux') {
			shell_exec('cp -t resources/js/assets/Section/ resources/js/global/Config.js resources/js/global/Plugin.js resources/js/global/Base.js resources/js/global/Component.js');
			shell_exec('mv Sidebar.js resources/js/assets/Section/');
		}
		else {
			shell_exec('rm Sidebar.js');
		}
		shell_exec('npm run dev && php artisan migrate && php artisan db:seed --class=UsersTableSeeder');
		shell_exec('mv _flag-icon-list.scss node_modules/flag-icon-css/sass/');
		$this->info('phantom installed!');

	}
}
