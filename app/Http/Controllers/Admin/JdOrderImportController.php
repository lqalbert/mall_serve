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
use App\Models\CustomerContact;

class JdOrderImportController extends Controller
{
	private $flag;
	private $sum;
	private $fileName;
    /**
	 *   $newData拆分成 订单表,商品表,客户表,收货地址表数据
	 *  订单表jd_order_basic:"订单号order_sn","下单帐号order_account","下单时间order_at","订单金额order_money",
	 *      "结算金额all_money","应付金额pay_money","余额支付pay_balance","订单状态status","订单类型type",
	 *      "订单备注remark","运费金额express_fee","支付方式pay_way",
	 *      "付款确认时间pay_confirm_at","订单完成时间end_at","订单来源order_source","订单渠道order_channel",
	 *      "送装服务install_service","服务费service_fee","是否为品牌商订单is_brand","是否为toplife订单is_toplife"
	 *                  
	 *  商品表jd_order_goods:"订单号order_sn","商品ID goods_id","货号sku_sn","商品名称goods_name","订购数量goods_num",
	 *      "京东价goods_price","仓库id entrepot_id","仓库名称entrepot_name"
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
	    	$uploadFile = $request->file('avatar');
	    	$this->fileName = $uploadFile->getClientOriginalName();
	    	$uploadFilePath= $request->file('avatar')->storeAs('import',$this->fileName,'excel');
	    	if(!$uploadFilePath){
	    		throw new \Exception("上传文件失败"); 
	    	}
	        $filePath = public_path('excel'.DIRECTORY_SEPARATOR.$uploadFilePath);
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
            $orderBasic[] = collect($v)->only(["order_sn","order_account","order_at","order_money",
                "all_money","pay_money","pay_balance","status","type","remark","express_fee","pay_way",
                "pay_confirm_at","end_at","order_source","order_channel","install_service","service_fee",
                "is_brand","is_toplife"])->map(function($item,$key){
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

            $orderGoods[] = collect($v)->only(["order_sn","goods_id","sku_sn","goods_name","goods_num",
                        "goods_price","entrepot_id","entrepot_name"])->toArray();

            $otherDatas[] = collect($v)->only(["order_sn","invoice_type","invoice_head","invoice_content",
                            "shop_remark", "shop_remark_level","add_tax_invoice","general_invoice_tax",
                            "shop_sku_id"])->toArray();
        }
        
        //商品表数据 orderGoods 其他表 otherDatas
        $orderGoods = [];
        $otherDatas = [];
        foreach ($newData as $key => $value) {
            $orderGoods[] = collect($value)->only(["order_sn","goods_id","sku_sn","goods_name","goods_num",
                            "goods_price","entrepot_id","entrepot_name"])->toArray();

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
                        "goods_price","entrepot_id","entrepot_name"])->toArray();
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
    	// $cus_id = CustomerContact::where('phone',13853125743)->first(['cus_id']);
    	// var_dump($cus_id->cus_id;
    	$jdCustomer = JdOrderCustomer::where('flag',$flag)->get();
    	dispatch((new JdOrderMatchUser($jdCustomer,$flag))->onConnection('redis'));
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






}
