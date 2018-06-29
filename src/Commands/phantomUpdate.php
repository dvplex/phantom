<?php

namespace dvplex\Phantom\Commands;

use Illuminate\Console\Command;

class phantomUpdate extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'phantom:update
        {key : Reg Key}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update phantom essential files';

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
		shell_exec('cp webpack.mix.js webpack.mix.js.b');
		$r = shell_exec("cp vendor/dvplex/phantom/src/phantom . && ./phantom -p -k {$key} && rm phantom");
		if (preg_match('/REG KEY/', $r)) {
			echo $r;
			exit;
		}
		shell_exec('mv webpack.mix.js.b webpack.mix.js');
		shell_exec('composer update');
		shell_exec('npm run dev && php artisan migrate');
		$this->info('phantom updated!');

	}
}
