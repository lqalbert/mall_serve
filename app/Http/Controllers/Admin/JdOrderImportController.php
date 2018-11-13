<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\JdOrderBasic;
use App\Models\JdOrderGoods;
use App\Models\JdOrderOther;
use App\Models\JdOrderCustomer;
use App\Models\JdOrderAddress;
use App\Models\JdMatchBasic;
use App\Jobs\JdOrderMatchUser;
use App\Jobs\JdOrderGoodsMinusInventory;
use App\Models\CustomerContact;
use App\Models\CustomerUser;
use App\Console\Commands\JdOrderSave;
use App\Services\JdOrder\JdOrderService;
use App\Services\Inventory\InventoryService;
use App\Services\DepositOperation\DepositOperationService;
use App\Models\JdDepositDetail;

class JdOrderImportController extends Controller
{
	private $flag;
	private $sum;
	private $fileName;
	private $entrepot_id;
    /**
	 *   $newData拆分成 订单表,商品表,客户表,收货地址表数据
	 *  订单表jd_order_basic:"订单号order_sn","下单帐号order_account","下单时间order_at","订单金额order_money",
	 *      "结算金额all_money","应付金额pay_money","余额支付pay_balance","订单状态status","订单类型type",
	 *      "订单备注remark","运费金额express_fee","支付方式pay_way",
	 *      "付款确认时间pay_confirm_at","订单完成时间end_at","订单来源order_source","订单渠道order_channel",
	 *      "送装服务install_service","服务费service_fee","是否为品牌商订单is_brand","是否为toplife订单is_toplife"
	 *                  
	 *  商品表jd_order_goods:"订单号order_sn","商品ID goods_id","货号sku_sn","商品名称goods_name","订购数量goods_num",
	 *      "京东价goods_price","仓库id jd_entrepot_id","仓库名称jd_entrepot_name"
	 *  
	 *  客户表jd_order_customer:"订单号order_sn","客户姓名cus_name","联系电话tel","下单帐号order_account"
	 *  
	 *  收货地址表jd_order_address:"订单号order_sn","客户姓名cus_name","客户地址address","联系电话tel",
	 *      "邮政编码zip_code","邮箱地址email"
	 *  
	 *  其他表jd_order_other:"订单号order_sn","发票类型invoice_type","发票抬头invoice_head","发票内容invoice_content",
	 *      "商家备注shop_remark", "商家备注等级（等级1-5为由高到低）shop_remark_level","增值税发票add_tax_invoice",
	 *      "普通发票纳税编号general_invoice_tax","商家SKUID shop_sku_id"
	 */
    public function index(Request $request){
    	// $exists = Storage::disk('excel')->exists('import/file.jpg');
    	try {
    		$this->entrepot_id = $request->input('entrepot_id');
	    	$uploadFile = $request->file('avatar');
	    	$this->fileName = $uploadFile->getClientOriginalName();
// 	    	$uploadFilePath= $request->file('avatar')->storeAs('import',$this->fileName,'excel');
	    	$uploadFilePath= $request->file('avatar')->store('excel');
	    	if(!$uploadFilePath){
	    		throw new \Exception("上传文件失败"); 
	    	}
// 	        $filePath = public_path('excel'.DIRECTORY_SEPARATOR.$uploadFilePath);
	    	$filePath = storage_path('app'.DIRECTORY_SEPARATOR.$uploadFilePath); 
	        $contentArr = file($filePath);
	        $csvArr = [];
	        foreach ($contentArr as $line) {
	            $convertString = iconv('GB2312','UTF-8//IGNORE', $line);
	            $csvArr[] = user_str_getcsv($convertString,",",'"');
	        }
        	$oldTitle = array_shift($csvArr);
	        $titleArr = JdOrderBasic::$fieldsName;
	        if(count($oldTitle) != count($titleArr)){
	        	throw new \Exception("excel数据不正确"); 
	        }

	        $i = 0; 
	        $columnLen = count($titleArr);
	        while ( $i < $columnLen) {
	            foreach ($csvArr as $k => $v) {
	                foreach ($v as $k1 => $v1) {
	                    if(!isset($v[$i])){
	                        $csvArr[$k][$i] = '';
	                    }
	                }
	                ksort($csvArr[$k]);
	            }
	            $i++;
	        }
	        
	        $newData = [];
	        foreach ($csvArr as $key => $value) {
	            $newData[] = array_combine($titleArr, $value);
	        }
	        // dd($titleArr);
	        // dd($newData);
	        $this->sum = count($newData);
	        $this->handleOrderDatas($newData);
    	} catch (\Exception $e) {
            return  $this->error([], "失败".$e->getMessage());
    	}
    	return  $this->success(["sum"=>$this->sum,"flag"=>$this->flag],"导入数据并保存成功");
	

        /*$fileType = mb_detect_encoding($content,['UTF-8','GBK','LATIN1','BIG5']);
        echo $filePath;
        $data = Excel::load($filePath,function($reader){
            // $data = $reader->all();
            // var_dump($reader->getTitle());
            // $reader->getTitle();
            // $reader->dump();
        },'gb2312')->convert('xls');//->toArray();*/
     
    }

    /**
     * [handleOrderDatas 对数据分组]
     * @param  array  $newData [description]
     * @return [type]          [description]
     */
    private function handleOrderDatas(array $newData){
 		//订单表数据 orderBasic 客户表cusBasic 收货地址orderAddress
        $s = collect($newData)->unique('order_sn');//去重 
        $orderBasic = [];
        $cusBasic = [];
        $orderAddress = [];
        $this->flag = time();
        foreach ($s as $k => $v) {
            $v['entrepot_id'] = $this->entrepot_id;
            $orderBasic[] = collect($v)->only(["order_sn","order_account","order_at","order_money",
                "all_money","pay_money","pay_balance","status","type","remark","express_fee","pay_way",
                "pay_confirm_at","end_at","order_source","order_channel","install_service","service_fee",
                "is_brand","is_toplife",'entrepot_id'])->map(function($item,$key){
                    if($key=='order_at' || $key=='pay_confirm_at' || $key=='end_at'){
                        if(!empty($item)){
                            $item = date("Y-m-d H:i:s",strtotime($item));
                        }
                    }
                    return $item;
                })->put('flag',$this->flag)->toArray();

            $cusBasic[] = collect($v)->only(["order_sn","cus_name","tel","order_account"])
            				->put('flag',$this->flag)->toArray();

            $orderAddress[] = collect($v)->only(["order_sn","cus_name","address","tel","zip_code",
        					"email"])->toArray();
        }
        
        //商品表数据 orderGoods 其他表 otherDatas
        $orderGoods = [];
        $otherDatas = [];
        foreach ($newData as $key => $value) {
            $orderGoods[] = collect($value)->only(["order_sn","goods_id","sku_sn","goods_name","goods_num",
                            "goods_price","jd_entrepot_id","jd_entrepot_name"])->put('flag',$this->flag)
                            ->put('entrepot_id',$this->entrepot_id)->toArray();

            $otherDatas[] = collect($value)->only(["order_sn","invoice_type","invoice_head","invoice_content",
                            "shop_remark", "shop_remark_level","add_tax_invoice","general_invoice_tax",
                            "shop_sku_id"])->toArray();
        }
        
        //以订单号为索引 暂时不用
/*        $sDatas = collect($newData)->groupBy('order_sn')->toArray();
        $orderGoods = $sDatas;
        $otherDatas = $sDatas;
        foreach ($orderGoods as $k1 => &$v1) {
            foreach ($v1 as $ke => &$val) {
                $val = collect($val)->only(["order_sn","goods_id","sku_sn","goods_name","goods_num",
                        "goods_price","jd_entrepot_id","jd_entrepot_name"])->toArray();
            }
            unset($val);
        }
        unset($v1);

        foreach ($otherDatas as $k2 => &$v2) {
            foreach ($v2 as $key => &$value) {
                $value = collect($value)->only(["order_sn","invoice_type","invoice_head","invoice_content",
                            "shop_remark", "shop_remark_level","add_tax_invoice","general_invoice_tax",
                            "shop_sku_id"])->toArray();
            }
            unset($value);
        }
        unset($v2);*/

        // dd($orderBasic);
        $this->soreOrderDatas($orderBasic,$cusBasic,$orderAddress,$orderGoods,$otherDatas);
    }

    /**
     * [soreOrderDatas 将数据存入数据库]
     * @param  [type] $basic   [description]
     * @param  [type] $cus     [description]
     * @param  [type] $address [description]
     * @param  [type] $goods   [description]
     * @param  [type] $other   [description]
     * @return [type]          [description]
     */
    private function soreOrderDatas($basic,$cus,$address,$goods,$other){
        // dd($goods);
        DB::beginTransaction();
        try {
            $reBasic = JdOrderBasic::insert($basic);
            if(!$reBasic){
                throw new \Exception("订单保存失败"); 
            }

            $reCus = JdOrderCustomer::insert($cus);
            if(!$reCus){
                throw new \Exception("订单客户保存失败"); 
            }

            $reAddress= JdOrderAddress::insert($address);
            if(!$reAddress){
                throw new \Exception("订单地址保存失败");
            }

            $reGoods= JdOrderGoods::insert($goods);
            if(!$reGoods){
                throw new \Exception("订单商品保存失败");
            }

            $reOther= JdOrderOther::insert($other);
            if(!$reOther){
                throw new \Exception("订单其他数据保存失败");
            }

            $reMatch = JdMatchBasic::create([
            	'flag' => $this->flag,
		    	'sum' => $this->sum,
		    	'file_name' => $this->fileName
            ]);
            if(!$reMatch){
            	throw new \Exception("订单匹配批次保存失败");
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }

        return  $this->success([],"导入数据并保存成功");

    }

    /**
     * [jdOrderList 获取导入到数据库的数据]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function jdOrderList(Request $request){
    	$model = new JdOrderBasic;

    	if ($request->has('start')) {
    		$start = $request->input('start')." 00:00:00";
            $model = $model->where('order_at','>=',$start);
        }

        if ($request->has('end')) {
        	$end = $request->input('end')." 23:59:59";
            $model = $model->where('order_at','<=',$end);
        }

        if($request->has('order_sn')){
        	$model = $model->where('order_sn',$request->input('order_sn'));
        }

        if($request->has('order_account')){
        	$model = $model->where('order_account',$request->input('order_account'));
        }

        if($request->has('flag')){
            $model = $model->where('flag',$request->input('flag'));
        }
        
        if ($request->has('department_id')) {
            $model = $model->where('department_id', $request->input('department_id'));
        }
        
        if ($request->has('group_id')) {
            $model = $model->where('group_id', $request->input('group_id'));
        }
        
        if ($request->has('user_id')) {
            $model = $model->where('user_id', $request->input('user_id'));
        }

        $result = $model->paginate($request->input('pageSize',15));
        $collection = $result->getCollection();
        $collection->load('goods','other','customer','address','department','group','user');

        $re = $collection->toArray();

        return [
        	'items'=>$re,
        	'total'=>$result->total()
        ];

    }
    /**
     * [matchUser 分发队列 匹配]
     * @param  Request $request [description]
     * @param  [type]  $flag    [description]
     * @return [type]           [description]
     */
    public function matchUser(Request $request,$flag){
    	// echo $flag;
    	$jdCustomer = JdOrderCustomer::where([
            ['flag','=',$flag],
            ['is_brusher','=',0],
        ])->get();
    	if(!($jdCustomer->isEmpty())){
    		dispatch((new JdOrderMatchUser($jdCustomer,$flag)));//->onConnection('redis'));
    		return $this->success([],"数据在后台匹配中,不影响操作其他页面");
    	}else{
    		return $this->error([],"该批次无客户数据,无法匹配");
    	}
    	
    }

    /**
     * [getMatch 获取批次列表]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getMatch(Request $request){
    	$re = JdMatchBasic::orderBy('id','desc')->get();
		return $re;
    	
    }

    public function minusInventory(Request $request,$flag){
        // echo $flag;
        $jdGoosd = JdOrderGoods::where('flag',$flag)->get();
        if(!($jdGoosd->isEmpty())){
        	dispatch((new JdOrderGoodsMinusInventory($jdGoosd,$flag))); //->onConnection('redis'));
    		return $this->success([],"数据在后台扣除中,不影响操作其他页面");
        }else{
        	return $this->error([],"该批次无商品数据,无法匹配");
        }

    }

    /**
     * [changeBrusher 更新是否为刷单标志]
     * @param  Request $request  [description]
     * @param  [type]  $flag     [description]
     * @param  [type]  $order_sn [description]
     * @return [type]            [description]
     */
    public function changeBrusher(Request $request,$flag,$order_sn){
        DB::beginTransaction();
        try {
            $where = [
                ['flag','=',$flag],
                ['order_sn','=',$order_sn]
            ];
            $model = JdOrderBasic::where($where)->firstOrFail();
            $is_brusher = $model->is_brusher==0?1:0;

            $re = JdOrderBasic::where($where)->update(['is_brusher'=>$is_brusher]);
            if(!$re){
                throw new \Exception("订单表更新失败");
                
            }
            
            $res = $model->goods()->update(['is_brusher'=>$is_brusher]);
            if(!$res){
                throw new \Exception("商品更新失败");
            }

            $resu = $model->customer()->update(['is_brusher'=>$is_brusher]);
            if(!$resu){
                throw new \Exception("客户表更新失败");
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }

        return $this->success([],"设置成功");
    }

    /**
     * [manualMatch 手动选择匹配]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function manualMatch(Request $request,JdOrderService $service){
        DB::beginTransaction();
        try {
            $data = $request->except('ids');
            $res = JdOrderBasic::whereIn('id', $request->input('ids'))->update($data);
            if(!$res){
                throw new \Exception("设置失败");
            }
            $orders = JdOrderBasic::whereIn('id', $request->input('ids'))->get();
            $service->manuMatch($orders);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
//             DD($e);
            return  $this->error([], $e->getMessage());
        }
        return  $this->success([], "匹配完成");
    
    }
    
    /**
     * 退回库存 未测试
     */
    public function backInventory(InventoryService $service, $id)
    {
        $order = JdOrderBasic::findOrFail($id);
        if (!$order->isReturnInventory()) {
            return $this->success([],'已经退回');
        }
        try {
            DB::beginTransaction();
            $service->jdOrder($order->entrepot, $order->goods, auth()->user(), $order->order_sn,false);
            $order->setduceInventory(false);
//             logger('[db]',[$order->is_deduce_inventory]);
            $re = $order->save();
            if (!$re) {
                throw new \Exception('退回失败');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }
        
        return $this->success([]);
    }
    
    /**
     * 退回返还 未测试
     */
    public function backDeposit(DepositOperationService $service, $id)
    {
        $order = JdOrderBasic::findOrFail($id);
        if (!$order->isDepositReturn()) {
            return $this->success([],'已经退回');
        }
        $service->subDeposit($order->department, $order->return_deposit, '退回返还 订单:JD'.$order->order_sn);
        $order->setDepositReturn(false);
        $order->return_deposit=0.00;
        $order->save();
        return $this->success([]);
    }
    
    public function depositDetail($id)
    {
        $re = JdDepositDetail::where('order_id',$id)->get();
        return [
            'items'=>$re,
            'total'=>$re->count()
        ];
    }


}
