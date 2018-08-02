<?php

namespace App\Http\Controllers\Admin;

use App\Models\OrderBasic;
use App\Models\OrderGoods;
use App\Models\OrderAddress;
use App\Models\GoodsDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\OrderlistRepository;
use App\Services\Orderlist\OrderlistService;
use App\Events\AddOrder;
use App\Events\OrderPass;
use App\Events\OrderCancel;
use App\Events\AddOrderOperationLog;
use App\Events\AddDepositOperationLog;
use App\Repositories\Criteria\FieldEqual;
use App\Repositories\Criteria\FieldLike;
use App\Models\User;
class OrderBasicController extends Controller
{


    private $model = null;
    private $repository = null;
    public function  __construct(OrderBasic $OrderBasic,OrderlistRepository $repository)
    {
        $this->model = $OrderBasic;
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business = $request->query('business', 'default');
        switch ($business){
            case 'Orderlist':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get();
                break;
            case 'select':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get();
                break;
            default:
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get();
        }
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
        // var_dump(auth()->user());die;
        DB::beginTransaction();
        try {
            $allData = $request->all();
            $allData['entrepot_id'] = auth()->user()->getEntrepotId();
            if ($allData['entrepot_id'] == 0) {
                throw new \Exception('没有绑定配送中心');
            }
            //添加一些字段数据
            $user = User::findOrFail($allData['user_id']);
            $group = $user->group()->select(['id','name'])->firstOrFail();
            $department = $user->department()->select(['id','name'])->firstOrFail();
            $allData['user_id'] = $user->id;
            $allData['user_name'] = $user->realname;
            $allData['group_id'] = $group->id;
            $allData['group_name'] = $group->name;
            $allData['department_id'] = $department->id;
            $allData['department_name'] = $department->name;

            $orderModel = OrderBasic::make($allData);
            $re = $orderModel->save();
            if (!$re) {
                throw new  \Exception('订单创建失败');
            }
            $orderGoodsModels = [];
            foreach ($request->order_goods as $goods) {
                $goods['unit_type'] = GoodsDetails::getUnitTypes($goods['unit_type']);
                $orderGoodsModels[] = OrderGoods::make($goods);
            }
            //                 $orderGoodsModels = array_map(function($goods){
            //                     return OrderGoods::make($goods);
            //                 }, $request->order_goods);
            if (!empty($orderGoodsModels)) {
                $orderModel->goods()->saveMany($orderGoodsModels);
            }
            $address = $request->address;
            unset($address['id']);
            $address['cus_id']=$allData['cus_id'];
            $orderAddressModels = OrderAddress::make($request->address);
            if (!empty($orderAddressModels)) {
                $orderModel->address()->save($orderAddressModels);
                $orderModel->address_id = $orderAddressModels->id;
                $orderModel->save();
            }
            event( new AddOrder($orderModel) );
            //添加订单操作记录事件
            $dataLog = [
                'order_id'=>$orderModel->id,
                'action'=>'add',
                'remark'=>$orderModel->order_sn
            ];
            event(new AddOrderOperationLog(auth()->user(),$dataLog));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }

        return $this->success([$orderModel->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\OrderBasic  $orderBasic
     * @return \Illuminate\Http\Response
     */
    public function show(OrderBasic $orderBasic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\OrderBasic  $orderBasic
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderBasic $orderBasic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\OrderBasic  $orderBasic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update 返回 bool
        //var_dump(Department::find($id));die();
        /* $res = array(
            'goods_id' => $request->input('goods_id'),
            'order_all_money' => $request->input('order_all_money'),
            'order_pay_money' => $request->input('order_pay_money'),
            'id' => $request->input('id'),
            'exchange_id' => $request->input('exchange_id'),
            'exchange_check' => $request->input('exchange_check'),
            'check_status' => $request->input('check_status'),
            'order_status' => $request->input('order_status'),
        ); */
        $re = $this->repository->update($request->all(), $id);
        if ($re) {
            //添加订单操作记录事件
            $dataLog = [
                'order_id'=>$request->input('id'),
                'action'=>'edit',
                'remark'=>$request->input('order_sn')
            ];
            event(new AddOrderOperationLog(auth()->user(),$dataLog));
            return $this->success($re);
            //return 1;
        } else {
            return $this->error($re);
            //return 2;
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\OrderBasic  $orderBasic
     * @return \Illuminate\Http\Response
     */
    public function exchangeGoods(Request $request, $id)
    {
        //update 返回 bool
        //var_dump(Department::find($id));die();
        $re = $this->repository->update($request->input(), $id);
        if ($re) {
            return $this->success($re);
            //return 1;
        } else {
            return $this->error($re);
            //return 2;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\OrderBasic  $orderBasic
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderBasic $orderBasic,$id)
    {
        $count = $this->model->destroy($id);
        if($count != 0){
            //添加订单操作记录事件
            $order_sn = $orderBasic::withTrashed()->where('id',$id)->value('order_sn');
            $dataLog = [
                'order_id'=>$id,
                'action'=>'delete',
                'remark'=>$order_sn
            ];
            event(new AddOrderOperationLog(auth()->user(),$dataLog));
            return $this->success([]);
        }else{
            return $this->error([]);
        }
        
    }

    public function updateCheckStatus(Request $request , $id)
    {
        $data = $request->all();
        $this->model = $this->model->find($id);
        $this->model->status = $data['status'];
        $re = $this->model->save();
        if ($re) {
            DB::beginTransaction();
            if ($data['status'] == 1) {
                try {
                    event( new OrderPass($this->model, auth()->user()));
                    //添加保证金日志
                    event(new AddDepositOperationLog(auth()->user(),$this->model,'check'));
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    return $this->error([], $e->getMessage());
                }
            }
            //添加订单操作记录事件
            $dataLog = [
                'order_id'=>$id,
                'action'=>'check',
                'remark'=>$data['order_sn']
            ];
            event(new AddOrderOperationLog(auth()->user(),$dataLog));
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }

    public function cancel(Request $request , $id)
    {
        DB::beginTransaction();
        try {
            $model = \App\Models\OrderBasic::find($id);
            if ($model->isAssign()) {
                throw new \Exception('已通过审核生成发货单，不能取消');
            }

            $re = $this->repository->update(['status'=> OrderBasic::CANCEL], $id);
            event(new OrderCancel($model));
            //添加保证金日志 暂时注释 后面再开放
            // event(new AddDepositOperationLog(auth()->user(),$model,'cancel'));
            //添加订单操作记录事件
            $order_sn = $this->model->where('id',$id)->value('order_sn');
            $dataLog = [
                'order_id'=>$id,
                'action'=>'cancel',
                'remark'=>$order_sn
            ];
            event(new AddOrderOperationLog(auth()->user(),$dataLog));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            logger('dd',[$e->getMessage()]);
            return $this->error([], $e->getMessage());
        }

        return $this->success([]);
    }
}
