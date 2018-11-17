<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JdOrderBasic;
use App\Models\JdOrderGoods;
use App\Models\JdOrderCustomer;
use App\Models\JdOrderAddress;
use App\Models\JdMatchBasic;
use App\Models\OrderBasic;
use App\Models\CustomerContact;
use Illuminate\Support\Facades\DB;

class JdOrderSave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:jd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'jd oreder transfer';

    protected $jdMatchModel;
    protected $flag;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->jdMatchModel = new JdMatchBasic();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $this->flag = time();

            $order = OrderBasic::where('type',4)->get();
            $order = $order->map(function ($res){
                return $res->setAppends(['status_text']);
            }); 
            $order->load('goods','address','customer','assign');
            $count = $order->count();

            $bar = $this->output->createProgressBar($count+1);//进度条
            foreach ($order as $v) {
                //JdOrderBasic表
                $this->jdBasicSave($v);

                //JdOrderGoods商品表
                $this->jdGoodsSave($v);

                //JdOrderAddress地址
                $this->jdAddressSave($v);
                
                //JdOrderCustomer 客户
                $this->jdCusSave($v);
                
                $bar->advance();
            }
            //JdMatchBasic 匹配表
            $this->jdMatchSave($count);
            DB::commit();
            $bar->advance();
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }
        $bar->finish();
        $this->info("  OK! jd order is saved");
    }

    /**
     * [jdBasicSave 保存订单表]
     * @param  [type] $v [description]
     * @return [type]    [description]
     */
    private function jdBasicSave($v){
        $jdBasicModel = new JdOrderBasic();

        $jdBasicModel->order_sn = $v->order_sn;
        $jdBasicModel->department_id = $v->department_id;
        $jdBasicModel->group_id = $v->group_id;
        $jdBasicModel->user_id = $v->user_id;
        $jdBasicModel->cus_id = $v->cus_id;
        $jdBasicModel->order_at = $v->created_at;
        $jdBasicModel->order_money = $v->order_all_money;
        $jdBasicModel->all_money = $v->order_all_money;
        $jdBasicModel->pay_money = $v->order_pay_money;
        $jdBasicModel->status = $v->status_text;
        $jdBasicModel->type = $v->type_object->name;
        $jdBasicModel->remark = $v->express_remark;
        $jdBasicModel->flag = $this->flag;
        $jdBasicModel->express_fee= $v->freight;
        $jdBasicModel->is_deduce_inventory= 1;
        $jdBasicModel->is_deposit_return= 1;
        $jdBasicModel->return_deposit= $v->return_deposit;
        $jdBasicModel->book_freight= $v->getDepositFreight();
        $jdBasicModel->entrepot_id= $v->entrepot_id;
        $jdBasicModel->match_state= 1;
        
//         if(!empty($v->assign->toArray())){
//             $jdBasicModel->express_fee = $v->assign[0]['express_fee'];
//         }

        if(!empty($v->assign->toArray())){
            $jdBasicModel->end_at = $v->assign[0]['sign_at'];
        }
        $res = $jdBasicModel->save();
        if(!$res){
            throw new \Exception("jd_order_basic is failed");
        }
    }

    /**
     * [jdGoodsSave 保存订单商品表]
     * @param  [type] $v [description]
     * @return [type]    [description]
     */
    private function jdGoodsSave($v){
        foreach ($v->goods as $vv) {
            $jdGoodsModel = new JdOrderGoods();

            $jdGoodsModel->order_sn = $v->order_sn;
            $jdGoodsModel->goods_id = $vv->goods_id;
            $jdGoodsModel->sku_sn = $vv->sku_sn;
            $jdGoodsModel->goods_name = $vv->goods_name;
            $jdGoodsModel->goods_num = $vv->goods_number;
            $jdGoodsModel->goods_price = $vv->price;
            $jdGoodsModel->entrepot_id = $v->entrepot_id;
            $jdGoodsModel->flag = $this->flag;
            $re = $jdGoodsModel->save();
            if(!$re){
                throw new \Exception("jd_order_goods is failed");
            }
        }
    }

    /**
     * [jdAddressSave 保存订单地址表]
     * @param  [type] $v [description]
     * @return [type]    [description]
     */
    private function jdAddressSave($v){
        $jdAddressModel = new JdOrderAddress();

        $jdAddressModel->order_sn = $v->order_sn;
        $jdAddressModel->cus_name = $v->address->name;
        $jdAddressModel->address = $v->address->address;
        $jdAddressModel->tel = $v->address->phone;
        $jdAddressModel->zip_code = $v->address->zip_code;
        $jdAddressModel->cus_name = $v->address->name;
        $resu = $jdAddressModel->save();
        if(!$resu){
            throw new \Exception("jd_order_address is failed");
        }
    }

    /**
     * [jdCusSave 保存客户表]
     * @param  [type] $v [description]
     * @return [type]    [description]
     */
    private function jdCusSave($v){
        $jdCusModel = new JdOrderCustomer();

        $jdCusModel->order_sn = $v->order_sn;
        $jdCusModel->cus_name = $v->cus_name;
        $jdCusModel->cus_id = $v->cus_id;
        $jdCusModel->tel = CustomerContact::where('cus_id',$v->cus_id)->value('phone');
        $jdCusModel->flag = $this->flag;
        $result = $jdCusModel->save();
        if(!$result){
            throw new \Exception("jd_order_customer is failed");
        }
    }

    /**
     * [jdMatchSave 存入批次表]
     * @param  [type] $count [description]
     * @return [type]        [description]
     */
    private function jdMatchSave($count){
        $this->jdMatchModel->flag = $this->flag;
        $this->jdMatchModel->sum = $count ;
        $this->jdMatchModel->match_status = JdOrderCustomer::MATCHED;
        $this->jdMatchModel->file_name = '命令行手动导入';
        $r = $this->jdMatchModel->save();
        if(!$r){
            throw new \Exception("jd_match_basic is failed");
        }
    }





}
