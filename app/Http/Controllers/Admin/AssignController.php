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

class AssignController extends Controller
{
    private $repository = null;
    
    private $fieldEqual = [
        'entrepot_id',
        'assign_sn',
        'status',//发货状态
        'corrugated_id',
        

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
            $this->repository->pushCriteria(new DateRange($range, $field));
        } 
        
        
        
        if (array_merge($order, $requestParams)) {
            $this->repository->pushCriteria(new Order($request));
        }
        
        if (array_merge($address, $requestParams)) {
            $this->repository->pushCriteria(new Address($request));
        }
        
//         foreach ($this->fieldEqual as  $value) {
//             if ($request->has($value)) {
//                 $this->repository->pushCriteria(new FieldEqual($value, $request->input($value)));
//             }
//         }
        
//         foreach ($this->fieldLike as  $value) {
//             if ($request->has($value)) {
//                 $this->repository->pushCriteria(new FieldLike($value, $request->input($value)));
//             }
//         }
        
//         if ($request->has('start') && $request->has('end')) {
//             $range= [];
//             $range[] = $request->input('start');
//             $range[] = $request->input('end');
//             $this->repository->pushCriteria(new DateRange($range));
//         } 
        
//         if ($request->has('with')) {
//             $with  = $request->input('with', []);
//             foreach ($with as $model) {
//                 if ($model == 'order') {
//                     $this->repository->with([$model=>function($query){
//                         $query->select('created_at');
//                     }]);
//                 }
//             }
//         }
        
        $pager = $this->repository->paginate($request->input('pageSize', 30), $request->input('fields',['*']));
        
        if ($request->has('appends')) {
            $collection = ModelCollection::setAppends($pager->getCollection(), $request->input('appends'));
        } else {
            $collection = $pager->getCollection();
        }


        if ($request->has('with')) {
            $with  = $request->input('with', []);
            if (!empty($with)) {
                $collection->load($with);
            }
//             foreach ($with as $model) {
//                 if ($model == 'order') {
//                     $collection->load([$model=> function($query){
//                         $query->select('created_at');
//                     }]);
//                 }
//             }
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
     * @todo 事件处理　操作记录
     * @param Request $request
     * @param unknown $id
     * @return number[]|string[]|NULL[]
     */
    public function check(Request $request , $id)
    {
        //pass_check
        //check_status
        //status
        //操作纪录可在这里处理　也可以用事件处理
        $data = $request->all();
        $data['pass_check'] = Carbon::now();
        $data['check_status'] = 1;
        $data['status'] = 1;
        unset($data['id']);
        $re = Assign::where('id', $id)->update($data);
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
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
//         {label:"审核状态", value:"2", sub:""},　分配了快递公司　纸箱　快递号　
//         {label:"录入状态", value:"3", sub:"删除发货单"},　//需要重新生成　发货单　原来的　快递号　要怎么处理　查看电子面单接口
//         注意这三个状态　需要改对应的字段　第三个暂时不需要改其它字段
        $assign = Assign::find($id);
        $is_repeat = $request->input('is_repeat');
        $assign->is_repeat = $is_repeat;
        $assign->repeat_mark = $request->input('repeat_mark');
        switch ($is_repeat) {
            case 1:
                $re = $assign->save();
                break;
            case 2:
                $re = $assign->save();
                break;
            case 3:
                $assign->express_id = 0;
                $assign->express_name = '';
                $assign->corrugated_case = '';
                $assign->corrugated_id = 0;
                $assign->express_sn = '';
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
