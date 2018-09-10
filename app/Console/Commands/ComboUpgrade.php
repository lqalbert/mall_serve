<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Goods;
use App\Models\OrderGoods;
use Illuminate\Support\Facades\DB;

class ComboUpgrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'combo:upgrade';

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
        $combos = Goods::IsCombo(true)->select('id','sku_sn')->get();
        $this->info("need to talk about how to deal with which already in orders combos");
        $this->info("at now ,I just make it to one way that is combos to endings");
        // 直接把组合的商品变成 签收状态
        //仓库数量直接扣
        //仓库明细 要添加吗？
        $ids = $combos->pluck('id');
        $ordergoods = OrderGoods::whereIn('goods_id', $ids)->where('created_at','<','2018-09-10 13:45:00')->get();
//         $goods->load('combos');
//         $allComboGoods = $goods->pluck('combos');
        DB::beginTransaction();
        try {
            foreach ($ordergoods as $item) {
                $goods = Goods::find($item->goods_id);
                $goodsCombos = $goods->combos;
                for ($i =0 ; $i< $item->goods_number ; $i++ ) {
                    foreach ($goodsCombos as $coGoods) {
                        //扣库存？
                        //                     DB::table('users')->decrement('votes', 5);
                        DB::table('inventory_system')->where('sku_sn', $coGoods->goods->sku_sn)->decrement('entrepot_count', $coGoods->num);
                        DB::table('inventory_system')->where('sku_sn', $coGoods->goods->sku_sn)->decrement('saleable_count', $coGoods->num);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->info($e->getMessage());
        }
        $this->info($this->signature. ' ok');
    }
}
