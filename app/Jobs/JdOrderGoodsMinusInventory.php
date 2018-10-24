<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use App\Models\JdOrderGoods;
use App\Models\JdMatchBasic;

class JdOrderGoodsMinusInventory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const TABLE = 'inventory_system';
    private $flag;
    private $jdGoosd;
    /**
     * 任务最大尝试次数
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($jdGoosd,$flag)
    {
        $this->jdGoosd = $jdGoosd;
        $this->flag = $flag;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->updateMinusStatus(JdOrderGoods::MINUSING);

        foreach ($this->jdGoosd as $v) {
            if($v->sku_sn){
                $re = $this->updates('set entrepot_count = entrepot_count - ? , saleable_count = saleable_count - ?, sale_count = sale_count + ? ',
                    [ $v->goods_num, $v->goods_num,$v->goods_num,$v->entrepot_id, $v->sku_sn ]);
                if($re != 0){
                    echo $re."行-sku_sn:".$v->sku_sn.PHP_EOL;
                }
            }
        }

        $this->updateMinusStatus(JdOrderGoods::MINUSED);
    }

    /**
     * [updates 包装更新]
     * @param  [type] $sql [description]
     * @param  [type] $arg [description]
     * @return [type]      [description]
     */
    private function updates($sql, $arg)
    {
        return DB::update('update '. self::TABLE.' '.$sql.' where entrepot_id = ? and sku_sn = ?', $arg);
    }

    /**
     * [updateMinusStatus 更新状态]
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    private function updateMinusStatus($status){
        JdMatchBasic::where('flag','=',$this->flag)->update(['inventory_status'=>$status]);
    }
    /**
     * 要处理的失败任务。
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        logger("[jdGoodsMinusError]", $exception->getMessage());
    }


}
