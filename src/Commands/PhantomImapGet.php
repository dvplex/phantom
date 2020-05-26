<?php

namespace dvplex\Phantom\Commands;

use dvplex\Phantom\Classes\PhantomImap;
use Illuminate\Console\Command;

class PhantomImapGet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phantom:imap-get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receives a new IMAP messages from a server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $imap = new PhantomImap();
        $imap->server=config('mail.host');
        $imap->user=config('mail.username');
        $imap->pass=config('mail.password');
	    $imap->connect();
        $totalMsg = $imap->totalMsg;
        $imap->flagMessages(1,1, 'unread',true);
        $msgs = $imap->getMessages();
        dd($msgs);
    }
}
