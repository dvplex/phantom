<?php

namespace dvplex\Phantom\Commands;

use dvplex\Phantom\Models\User;
use Illuminate\Console\Command;
use Modules\Modules\Entities\Module;

class PhantomForm extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'phantom:form {name : The name of the form class} {--A|action=default : Form Action} {--F|fields=name:text:Name,description:textarea:Description : A comma separated list of fields in format NAME:TYPE:LABEL} {--m|module : weather to add the form to a module or in the app itself. If choosen a table with available modules will be displayed.}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Creates a new html form";

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
		$module = 'App';
		$name = $this->argument('name');
		if ($this->option('module')) {
			$headers = ['No.', 'Name'];
			$modules = \Nwidart\Modules\Facades\Module::all();
			$mods = [];
			$md = [];
			$md[0] = 'Without module';
			$n =1;
			foreach ($modules as $module) {
				$md[] = $module->getName();
				$mods[$n]['index'] = $n;
				$mods[$n]['name'] = $module->getName();
				$n++;
			}

			$module = 'Modules/'.$this->choice('Please choose a module ( empty to add form to application itself): ', $md , 0);
		}

		$fld = $this->option('fields');


		if ($fld) {
		    $form = \dvplex\Phantom\Classes\PhantomForm::generate($fld,$module,$this->argument('name'),$this->option('action'));
		    return $this->info($form);
		}



	}
}
