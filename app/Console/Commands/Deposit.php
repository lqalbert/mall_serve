<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DepositSet;

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
    protected $description = 'Command description';

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
        DepositSet::create([
            'type'=>0,
            'appendage_rate'=>30,
            'sale_rate' => 0,
            'return_rate' => 0
        ]);
    }
}
