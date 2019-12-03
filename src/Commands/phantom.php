<?php

namespace dvplex\Phantom\Commands;

use dvplex\Phantom\Models\Role;
use dvplex\Phantom\Models\User;
use dvplex\Phantom\Modules\Menus\Entities\Menu;
use Illuminate\Console\Command;

class phantom extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phantom:install {--U|update : Update only}';

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
        if (!$this->option('update') && !is_file('phantom.setup.ready'))
            dd('Please run first php artisan phantom:setup');
        $this->info('Unpacking files...');
        $zip = new \ZipArchive();
        $res = $zip->open(__DIR__ . '/../phantom.zip');
        if ($res === TRUE) {
            $zip->extractTo(base_path());
            $zip->close();
            $this->info('Phantom extracted');
        }
        else {
            $this->error('Problem with package archive!');
            exit;
        }

        if (substr(php_uname(), 0, 7) == "Windows") {
            pclose(popen("start /B composer dump-autoload", "r"));
        }
        else {
            shell_exec("composer dump-autoload");
        }
        $this->info("Migrating Database");
        $this->call('migrate');
        $u = User::first();
        if (!$u)
            $this->call('db:seed', ['--class' => 'dvplex\\Phantom\\Seeds\\UsersTableSeeder']);
        $rol = Role::first();
        if (!$rol)
            $this->call('db:seed', ['--class' => 'dvplex\\Phantom\\Seeds\\RolesTableSeeder']);
        $men = Menu::first();
        if (!$men)
            $this->call('db:seed', ['--class' => 'dvplex\\Phantom\\Seeds\\MenusTableSeeder']);
        $this->info("Database migrated and seeded!");

        $this->info('Publishishing files...');
        $this->call('vendor:publish',[
            '--provider' =>'dvplex\Phantom\PhantomServiceProvider'
        ]);

        $this->info("Installing npm modules...");
        if (substr(php_uname(), 0, 7) == "Windows") {
            pclose(popen("start /B npm install", "r"));
            pclose(popen("start /B npm run dev", "r"));
        }
        else {
            shell_exec('chmod 777 -R storage/');
            shell_exec("npm install");
            shell_exec("npm run dev");
        }
        if (!$this->option('update'))
            unlink('phantom.setup.ready');

        if (!$this->option('update'))
            $this->info('Phantom successfully installed!');
        else
            $this->info('Phantom successfully upgraded!');
    }
}
