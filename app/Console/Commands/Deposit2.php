<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DepositSet2;

class Deposit2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deposit2:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设置保证金2设置';

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
        $re = DepositSet2::create([
            'type'=>0,
            ''
        ]);
        if ($re) {
            $this->info('Display this on the screen');
        } else {
            $this->error('Something went wrong!');
        }
    }
}
