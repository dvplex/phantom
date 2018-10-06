<?php

namespace dvplex\Phantom\Commands;

use Illuminate\Console\Command;

class phantomInitialSetup extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'phantom:setup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setups database and project name';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}
	protected function project_name() {
		$pname = $this->ask('Please enter Project name');
		if ($this->confirm('Change project name to ' . $pname . '?')) {
			shell_exec("sed -i -e 's/APP_NAME=.*$/APP_NAME={$pname}/g' .env");

			return true;
		}
		else
			$this->project_name();
	}

	protected function dbsetup() {
		$db = [];
		$db['name'] = $this->ask('Please enter database name');
		$db['user'] = $this->ask('Please enter username for the database');
		$db['pass'] = $this->ask('Please enter database password');

		$this->info('Database name: ' . $db['name']);
		$this->info('Database username: ' . $db['user']);
		$this->info('Database password: ' . $db['pass']);
		if ($this->confirm('Is this info correct?')) {
			shell_exec("sed -i -e 's/DB_DATABASE=.*$/DB_DATABASE={$db['name']}/g' .env");
			shell_exec("sed -i -e 's/DB_USERNAME=.*$/DB_USERNAME={$db['user']}/g' .env");
			shell_exec("sed -i -e 's/DB_PASSWORD=.*$/DB_PASSWORD={$db['pass']}/g' .env");

			return true;
		}
		else
			$this->dbsetup();
	}


	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$this->project_name();
		$this->dbsetup();
		file_put_contents('phantom.setup.ready',1);
	}
}
