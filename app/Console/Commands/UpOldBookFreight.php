<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderBasic;
use App\Models\OrderAddress;

class UpOldBookFreight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order_update:old_book_freight';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '旧的包邮订单book_freight升级';

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
        
        OrderBasic::where([
            ['include_freight','=',1],
            ['book_freight','=','0.00']
        ])->whereIn('type',[2,3])
        ->where([ ['status','>',0], ['status','<',7]])
        ->whereNull('deleted_at')
        ->chunk(100, function($orders) {
            foreach ($orders as $order) {
                switch ($order->express_delivery) {
                    case '顺丰':
                        $order->book_freight = 12.00;
                        break;
                    case 'EMS':
                        $order->book_freight = 18.00;
                        break;
                    default:
                        //偏远地区 新疆650000  宁夏 640000 青海省630000  西藏540000
                        $address = OrderAddress::where('order_id', $order->id)->first();
                        if (in_array($address->area_province_id, [650000,640000,630000,540000])) {
                            $order->book_freight = 18.00;
                        } else {
                            $order->book_freight = 10.00;
                        }
                        //不是
                }
                $order->save();
            }
        });
        
            $this->info('done');
    }
}
