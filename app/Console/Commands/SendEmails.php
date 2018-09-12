<?php

namespace App\Console\Commands;

use App\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an Email to subscribers';

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
        $today = Carbon::today()->toDateString();
        $subscr = Subscription::where('sending_date',$today)->where('is_active',1)->where('done',0)->first();
        if(!empty($subscr)){
            $subscr->done = 1;
            $subscr->save();
        }
    }
}
