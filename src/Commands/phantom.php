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
	public function handle() {
		$key = $this->secret('Please enter secret');
		$platform = shell_exec('uname -s');
		if ($platform == 'Linux')
			$r = shell_exec("cp vendor/dvplex/phantom/src/phantom_linux . && ./phantom_linux -i -k {$key} && rm phantom_linux");
		else
			$r = shell_exec("cp vendor/dvplex/phantom/src/phantom . && ./phantom -i -k {$key} && rm phantom");
		if (preg_match('/REG KEY/', $r)) {
			echo $r;
			exit;
		}
		shell_exec('composer update');
		shell_exec('composer require dvplex/phantom');
		shell_exec('npm install');
		$platform = shell_exec('uname -s');
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
