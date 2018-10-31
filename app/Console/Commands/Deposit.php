<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DepositSet;
use App\Models\OrderBasic;

class Deposit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deposit:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设置保证金设置';

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
        OrderBasic::whereNull('deleted_at')->update(['is_deposit_return'=>1]);
        $re = DepositSet::create([
            'type'=>0,
            'appendage_rate'=>30,
            'sale_rate' => 0,
            'return_rate' => 67
        ]);
        if ($re) {
            $this->info('Display this on the screen');
        } else {
            $this->error('Something went wrong!');
        }
        
    }
}
