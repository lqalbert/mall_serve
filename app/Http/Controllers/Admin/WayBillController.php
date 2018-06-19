<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Assign;
use App\Services\WayBill\WayBillService;
use App\Services\WayBill\MsgType\TmsWayBillSubscriptionQuery;
use App\Models\ExpressCompany;
use App\Services\WayBill\MsgType\TmsWayBillGet;
use App\Services\WayBill\MsgType\TmsWayBillUpdate;


/**
 * @todo 返回数据要处理　比如　面单号　打印数据要保存
 * @author hyf
 *
 */
class WayBillController extends Controller
{
    public function __construct(Request $request, WayBillService $serve)
    {  
       $this->request  = $request; 
       $this->serve = $serve;
       
    }
    
    /**
     * 获取/更新一个电子面单
     * @param unknown $assign_id
     * @param unknown $express_id
     * @return number[]|string[]|unknown[][]|array[]|unknown[]
     */
    public function getOne($assign_id, $express_id)
    {
        //判断一下是　全新的　还是　更新
        $assign = Assign::select(['express_id','express_sn'])->findOrFail($assign_id);
        $express = ExpressCompany::find($express_id);
        if ($assin->express_id !=  $express_id) { //全新的
            $cmd = new TmsWayBillGet();
            $cmd->setParam($assign, $express, $assign->order, auth()->user()->id);
        } else {
            //更新的
            $cmd = new TmsWayBillUpdate();
            $cmd->setParam($assign, $express, $assign->order);
        }
        return $this->serve->send($cmd);
    }
    
    /**
     * 一个快递公司对应一个发货地址
     */
    public function setSender()
    {
        $query = new TmsWayBillSubscriptionQuery();
        $query->setParam(['cpCode'=>'ZTO']);
        return $this->serve->send($query);
    }
    
    
}
