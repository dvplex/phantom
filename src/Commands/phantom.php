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


	protected function download($platform) {
		$key = $this->secret('Please enter secret');
		if ($platform == 'Linux')
			$r = shell_exec("cp vendor/dvplex/phantom/src/phantom_linux . && ./phantom_linux -i -k {$key} && rm phantom_linux");
		else
			$r = shell_exec("cp vendor/dvplex/phantom/src/phantom . && ./phantom -i -k {$key} && rm phantom");
		if (preg_match('/REG KEY/', $r) || !$key) {
			$this->error('Wrong key!');
			$this->download($platform);
		}
	}

	public function handle() {
		if (!is_file('phantom.setup.ready'))
			dd('Please run first "php artisan phantom:setup"');
		$platform = trim(shell_exec('uname -s'));
		$this->line('Platform is ' . $platform);
		$this->download($platform);
		shell_exec('composer update');
		shell_exec('composer require dvplex/phantom');
		shell_exec("perl -p -i -e 's/fire\(/dispatch\(/g' vendor/nwidart/laravel-modules/src/Module.php");
		shell_exec("perl -p -i -e 's/fire\(/dispatch\(/g' vendor/baum/baum/src/Baum/Move.php");
		$this->info("Migrating Database");
		sleep(1);
		$r = shell_exec('php artisan migrate && php artisan db:seed --class=UsersTableSeeder');
		print_r($r);
		$this->info("Database migrated and seeded!");
		shell_exec('npm install');
		if ($platform == 'Linux') {
			shell_exec('cp -t resources/js/assets/Section/ resources/js/global/Config.js resources/js/global/Plugin.js resources/js/global/Base.js resources/js/global/Component.js');
			shell_exec('mv Sidebar.js resources/js/assets/Section/');
		}
		else {
			shell_exec('rm Sidebar.js');
		}
		shell_exec('mv _flag-icon-list.scss node_modules/flag-icon-css/sass/');
		shell_exec('npm run dev');
		if ($platform == 'Linux')
			shell_exec('chmod 777 -R storage/');
		shell_exec('rm phantom.setup.ready');
		$this->info('phantom installed!');

	}
}
