<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Inventory\System;
use App\Models\Assign;
use Illuminate\Support\Facades\DB;

class RestoreSending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:sending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '发货锁定变成发货在途';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(System $s)
    {
        parent::__construct();
        $this->inventory = $s;
    }

    /**
     * Execute the console command.
     * 
     * 把已发货的改成 发货在途
     * @return mixed
     */
    public function handle()
    {
        $assigns = Assign::sended()->get();
        DB::beginTransaction();
        try {
            foreach ($assigns as $item) {
                $this->inventory->sending($item->entrepot_id, $item->goods);
            }
        } catch (Exception $e) {
            DB::rollback();
            $this->error('Something went wrong!');
        }
        DB::commit();
        $this->info('OK');
        
        
        
    }
}
