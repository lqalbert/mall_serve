<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpgradeOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade:one';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '升级';

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
        $this->call('store:sending');
        $this->call('order:type_object');
    }
}
