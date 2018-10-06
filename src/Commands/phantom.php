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
		$key = $this->argument('key');
		$platform = shell_exec('uname -s');
		if ($platform == 'Linux')
			$r = shell_exec("cp vendor/dvplex/phantom/src/phantom . && ./phantom -i -k {$key} && rm phantom");
		else
			$r = shell_exec("cp vendor/dvplex/phantom/src/phantom_linux . && ./phantom_linux -i -k {$key} && rm phantom_linux");
		if (preg_match('/REG KEY/', $r)) {
			echo $r;
			exit;
		}
		shell_exec('composer update');
		shell_exec('composer require dvplex/phantom');
		shell_exec('npm install');
		shell_exec('npm run dev && php artisan migrate && php artisan db:seed --class=UsersTableSeeder');
		$this->info('phantom installed!');

	}
}
