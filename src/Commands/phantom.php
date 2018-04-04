<?php

namespace dvplex\Phantom\Commands;

use Illuminate\Console\Command;

class phantom extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'phantom:install
        {key : Reg Key}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initialize phantom files:w';

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
		$key = $this->argument('key');
		$r = shell_exec("cp vendor/dvplex/phantom/src/phantom . && ./phantom -i -k {$key} && rm phantom");
		if (preg_match('/REG KEY/', $r)) {
			echo $r;
			exit;
		}
		shell_exec('composer remove dvplex/phantom');
		shell_exec('composer require dvplex/phantom');
		shell_exec('composer update');
		shell_exec('npm install');
		shell_exec('npm run dev');
		shell_exec('php artisan migrate');
		shell_exec('php artisan db:seed --class=UsersTableSeeder');
		$this->info('phantom installed!');

	}
}
