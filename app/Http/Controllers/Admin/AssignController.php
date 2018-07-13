<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\AssignRepository;
use App\Repositories\Criteria\FieldEqual;
use App\Repositories\Criteria\FieldLike;
use App\Alg\ModelCollection;
use App\Events\Signatured;
use App\Models\Assign;
use App\Models\Communicate;
use App\Repositories\Criteria\Ordergoods\DateRange;
use Carbon\Carbon;
use App\Repositories\Criteria\Assign\Order;
use App\Repositories\Criteria\Assign\Address;
use App\Repositories\Criteria\FieldEqualLessThan;
use App\Services\WayBill\WayBillService;
use App\Models\ExpressCompany;
use App\Services\WayBill\MsgType\TmsWayBillGet;
use Illuminate\Support\Facades\Storage;
use App\Models\CartonManagement;
use App\Models\ExpressPrice;
use App\Models\VolumeRatio;
use Illuminate\Support\Facades\DB;

class AssignController extends Controller
{
    private $repository = null;
    
    private $fieldEqual = [
        'entrepot_id',
        'assign_sn',
        'status',//发货状态
        'corrugated_id',
        'express_sn', //物流揽件要用
        'order_id', //订单下面查询要用

    ];
    
//     private $fieldLike = [
//         'goods_name',
//         'sale_name',
//         'deliver_name',
//         'deliver_phone',
//         'express_name',
//         'user_name'
//     ];
    
    public function __construct(AssignRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     * @todo 后端start end 日期没加上
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        //分成几类
        
        //assign 本表的　发货单　箱类型　查询日期　range
        //order 表的　订单编号　订单金额　订单备注
        //order_address表的　收货人　收货手机　收货省份　收货城市
        //order_goods表　商品类型　
        
        $assign = [
            'assign_sn',
            'corrugated_id',
            'auto_field',
            'range',
            'status',
            'entrepot_id',
            
        ];
        
        $order = [
            'order_sn',
            'price_range', // 0 1 2 3 
            'express_remark'
        ];
        $address = [
            'name',
            'phone',
            'area_province_id',
            'area_city_id'
        ];
        $goods = [
          'cate_ids'  
        ];
        
        $requestParams= $request->all();
        //忘了为什么这么写
        if (array_merge($assign, $requestParams)) {
            foreach ($this->fieldEqual as  $value) {
                if ($request->has($value)) {
                    $this->repository->pushCriteria(new FieldEqual($value, $request->input($value)));
                }
            }
        }
        
        
        $is_repeat = $request->input('is_repeat', 2);
        $this->repository->pushCriteria(new FieldEqualLessThan('is_repeat', $is_repeat));
        
        if ($request->has('range')) {
            $field = $request->input('auto_field', 'created_at');
            $range = $request->input('range');
            $this->repository->pushCriteria(new DateRange($range, $field));
        } 
        

        if (array_merge($order, $requestParams)) {
            $this->repository->pushCriteria(new Order($request));
        }
        
        if (array_merge($address, $requestParams)) {
            $this->repository->pushCriteria(new Address($request));
        }
        
        if ($request->has('with')) {
            $this->repository->with($request->input('with'));
        }
        
        $pager = $this->repository->paginate($request->input('pageSize', 30), $request->input('fields',['*']));
        
        if ($request->has('appends')) {
            $collection = ModelCollection::setAppends($pager->getCollection(), $request->input('appends'));
        } else {
            $collection = $pager->getCollection();
        }

        if ($request->has('load')) {
            $collection->load($request->input('load'));
        }

        $result = [
            'items' => $collection,
            'total' => $pager->total()
        ];
        
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    
    // public function showbyExpressSn(Request $request, $express_sn)
    // {
    //     $model = Assign::where('express_sn', $express_sn)->first();
    //     if (!$model) {
    //         return $this->error([]);
    //     }
    //     if ($request->has('with')) {
    //         $with = $request->input('with');
    //         foreach ($with as $item) {
    //             $model->{$item};
    //         }
    //     }
    //     return $this->success($model);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @todo 事件处理　操作记录
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $re = $this->repository->update($request->all(), $id);
//         if ($request->has('sign_at')) {
//             event(new Signatured(Assign::find($id)));
//         }
        if($re){
            return $this->success($re);
        }else{
            return $this->error($re);
        }

    }
    
    /**
     * 审核
     * 
     * @todo 事件处理　操作记录 
     * @param Request $request
     * @param unknown $id
     * @return number[]|string[]|NULL[]
     */
    public function check(Request $request, WayBillService $service)
    {
        //pass_check
        //check_status
        //status
        //操作纪录可在这里处理　也可以用事件处理
        $ids = $request->input('ids', []);
        $data = $request->all();
        $data['pass_check'] = Carbon::now();
        $data['check_status'] = 1;
        $data['status'] = 1;
        unset($data['ids']);
        
        $ids = $request->input('ids', []);
        $re = Assign::whereIn('id', $ids)->update($data);
        if ($re) {
            //处理面单请求
            //直接申请新的吧
            
            $express = ExpressCompany::find($data['express_id']);
            $assigns = Assign::find($ids);
            $cmd = new TmsWayBillGet();
            $cmd->setParam($assigns, $express, auth()->user()->id);
            $re =  $service->send($cmd);
            //根据返回的re 来处理
            //成功要保存数据
           if ($re['status'] == 1) { //成功
               $cainiodata = $re['data'];
               if (count($cainiodata) == 0) {
                   return $this->error([],'面单获取失败:数量为0');
               }
               foreach ($cainiodata as $item) {
                   Assign::where('id', $item['objectId'])->update(['express_sn'=> $item['waybillCode'], 'print_data'=> $item['printData']]);
               }
           } else {
               return $this->error([], '面单获取失败:'.$re['msg']);
           }
            
//            Storage::disk('local')->put('waybill.json', json_encode($re));
            return $this->success([]);
        } else {
            return $this->error([],'aa');
        }
        
    }
    
    
    /**
     * 返单
     * @todo 事件处理　操作记录
     * @param Request $request
     * @param unknown $id
     */
    public function repeatOrder(Request $request, $id)
    {
//         {label:"导入状态", value:"1", sub:""},
//         {label:"审核状态", value:"2", sub:""},　分配了快递公司　　快递号　快递号(面单可以更新)
//         {label:"录入状态", value:"3", sub:"删除发货单"},　//需要重新生成　发货单　原来的　快递号　要怎么处理　查看电子面单接口
//         注意这三个状态　需要改对应的字段　第三个暂时不需要改其它字段
        $assign = Assign::find($id);
        $is_repeat = $request->input('is_repeat');
        $assign->is_repeat = $is_repeat;
        $assign->repeat_mark = $request->input('repeat_mark');
        switch ($is_repeat) {
            case 1:
                if (!$assign->isSetExpress()) {
                    $assign->express_id = 0;
                    $assign->express_name = '';
                    $assign->express_sn = '';
                }
                $assign->corrugated_case = '';
                $assign->corrugated_id = 0;
                $re = $assign->save();
                break;
            case 2:
                $re = $assign->save();
                break;
            case 3:
                
//                 $assign->corrugated_case = '';
//                 $assign->corrugated_id = 0;
//                 $assign->express_sn = '';
                $re = $assign->save();
                break;
            default:
                throw new \Exception('错误');
                break;
        }

        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }
    
    
    /**
     * 拦截 toggle类型的操作 
     * @todo 事件处理　操作记录
     * @param Request $request
     * @param unknown $id
     */
    public function stopOrder(Request $request, $id)
    {   
        $assign = Assign::find($id);
        $is_stop = $request->input('is_stop');
        $assign->is_stop = $is_stop==0?1:0;
        $assign->stop_mark = $request->input('stop_mark');
        $re = $assign->save();
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }
    
    
    /**
     * 面单打印
     * @todo 事件处理　操作记录
     * 打印
     */
    public function waybillPrint(Request $request, $id)
    {
        $assign = Assign::find($id);
        $assign->updateWaybillPrintStatus();
        $re = $assign->save();
        $express = $assign->express;
        if ($re) {
            return $this->success(['express_sn'=>$assign->express_sn,'printer'=>$express->printer,'print_data'=>$assign->print_data]);
        } else {
            return $this->error([]);
        }
    }
    
    /**
     * @todo 事件处理　操作记录
     * @param Request $request
     * @return number[]|string[]|NULL[]
     */
    public function goodsPrint(Request $request, $id)
    {
        $assign = Assign::find($id);
        $assign->updateAssignPrintStatus();
        $goods  = $assign->goods;
        $re = $assign->save();
        if ($re) {
            return $this->success($goods);
        } else {
            return $this->error([]);
        }
    }


    /**
     * 验货
     * @todo 事件处理　操作记录
     */
    public function checkGoods(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $assign = Assign::find($id);
            $assign->load('goods');//
            $goodsArr = collect($assign->toArray())->get('goods');
            $goodsVolume = 0;
            $goodsWeight = 0;
            foreach ($goodsArr as $goods) {
                $goodsVolume += $goods['width']*$goods['height']*$goods['len'];
                $goodsWeight += $goods['goods_number']*$goods['weight']+$goods['goods_number']*$goods['bubble_bag'];
            }
            
            $per = VolumeRatio::first(['volume_ratio']);
            
            if(!$per){
                throw new  \Exception('纸箱获取失败,未设置纸箱比例');
            }
            $carton = CartonManagement::where([ 
                ['carton_volume','<=',$goodsVolume/$per->volume_ratio * 100],
                ['carton_volume','<',$goodsVolume ]                
            ])
                                        ->orderBy('carton_volume')->first();
            if(!$carton){
                throw new  \Exception('获取纸箱型号失败！');
            }
            $assign->corrugated_case = $carton->carton_name;
            $assign->corrugated_id = $carton->id;
            $assign->corrugated_weight = $carton->carton_weight;
            $assign->reckon_weigth =  $goodsWeight+$carton->carton_weight;
            $assign->checkedGoods(auth()->user());
            $re = $assign->save();
            if(!$re){
                throw new  \Exception('纸箱分配保存失败');
            }
            $msg = $carton->carton_number == 0 ?'合适的纸箱数量为0':'操作成功';

            $cartonModel = CartonManagement::find($carton->id);
            $cartonModel->minusCartonNumber($carton->carton_number);
            $cartonModel->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }
        return $this->success([],$msg);  
    }

    public function showbyExpressSn(Request $request, $express_sn)
    {
        $model = Assign::where('express_sn', $express_sn)->first();
        if (!$model) {
            return $this->error([]);
        }
        if ($request->has('with')) {
            $with = $request->input('with');
            foreach ($with as $item) {
                $model->{$item};
            }
        }

        $result = $model->toArray();

        if($request->has('field')){
            $expressPrice = $this->getGoodsExpressPrice($result);
            $result['express_price']=$expressPrice;
        }

        return $this->success($result);
    }

    public function getGoodsExpressPrice($result){
        $district = $result['address']['area_district_id'];//区
        $city = $result['address']['area_city_id'];//市
        $province = $result['address']['area_province_id'];//省

        $where = [
            ['express_id','=',$result['express_id']],
            ['is_use','=',ExpressPrice::IS_USE],
        ];

        $expressModel = new ExpressPrice;
        $expressModel = $expressModel->where($where);

        $expressPrice = null;
        $priceModel = $expressModel->where('area_district_id',$district)->first();//一维数组
        if(!$priceModel){
            array_push($where, ['area_city_id','=',$city]);
            $priceModel = ExpressPrice::where($where)->first();
            if(!$priceModel){
                array_pop($where);
                array_push($where,['area_province_id','=',$province]);
                $priceModel = ExpressPrice::where($where)->first();
            }
        }
        if($priceModel){
            $expressPrice = $priceModel->toArray();
        }

        return $expressPrice;
    }

    /**
     * 称重发货
     * @todo 事件处理　操作记录
     */
    public function weightGoods(Request $request, $id)
    {
        //减库存
        // var_dump($request->all());die();
        $assign = Assign::find($id);
        $real_weigth = $request->input('real_weigth');
        $express_fee = $request->input('express_fee',0);
        $assign->weightGoods($real_weigth,$express_fee,auth()->user());
        $re = $assign->save();
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
