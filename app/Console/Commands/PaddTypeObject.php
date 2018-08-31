<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderBasic;

class PaddTypeObject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:type_object';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '填充 order_basic type_object';

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
        $orders = OrderBasic::whereNull('type_object')->get();
        foreach ($orders as $item) {
            $item->typeToPlanObject();
            $re = $item->save();
            if ($re) {
                $this->info('OK');
            } else {
                $this->info('no');
            }
        }
    }
}
