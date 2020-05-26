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
            $env = file_get_contents('.env');
            if (preg_match('/\s+/', $pname))
                $pname = "\"{$pname}\"";
            $env = preg_replace('/APP_NAME=(.*)/', "APP_NAME={$pname}", $env);
            file_put_contents('.env', $env);

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
            $env = file_get_contents('.env');
            $env = preg_replace('/DB_DATABASE=(.*)/', "DB_DATABASE={$db['name']}", $env);
            $env = preg_replace('/DB_USERNAME=(.*)/', "DB_USERNAME={$db['user']}", $env);
            $env = preg_replace('/DB_PASSWORD=(.*)/', "DB_PASSWORD={$db['pass']}", $env);
            file_put_contents('.env', $env);

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
        $jsonString = file_get_contents(base_path('composer.json'));
        $data = json_decode($jsonString, true);
        $data['autoload']['psr-4']['Modules\\'] = 'Modules/';
        $jsonString = json_encode($data,JSON_UNESCAPED_SLASHES);
        file_put_contents(base_path('composer.json'),$jsonString);
        $this->project_name();
        $this->dbsetup();
        file_put_contents('phantom.setup.ready',1);
        $this->info('Phantom is now ready to install! Please run php artisan phantom:install');

    }
}
