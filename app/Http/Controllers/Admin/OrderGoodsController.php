<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\OrderGoods;
use App\Models\OrderBasic;
use App\Services\Ordergoods\OrdergoodsService;
use App\Repositories\OrdergoodsRepository;
use App\Repositories\Criteria\Ordergoods\Ordergoods as OrdergoodsC;
use Illuminate\Support\Facades\DB;
use App\Services\Inventory\InventoryService;
class OrderGoodsController extends Controller
{
    //
    private $repository = null;
    public function  __construct(OrdergoodsRepository $repository)
    {
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
        $result = [];
        switch ($business){
            case 'select':
                $service = app('App\Services\Ordergoods\OrdergoodsService');
                $result = $service->get();
                break;
            default:
                $service = app('App\Services\Ordergoods\OrdergoodsService');
                $result = $service->get();
        }
        return $result;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventoryService  $service, $id)
    {
        DB::beginTransaction();
        try {
            $orderModel = OrderBasic::find($request->order_id);
            $orderCheck = $orderModel->isPass();
            if($orderCheck){
                return $this->error([], "审核未通过或通过审核不能更新");
            }

            $data = $request->all();
            $model = OrderGoods::findOrFail($id);
            
            $deta_num = $model->getNum() - $data['goods_number'];
            if ($deta_num != 0) {
                $model->goods_number = -$deta_num;
                if ($model->goods_number > 0) {
                    $service->saleLock( $orderModel->entrepot, [$model], $request->user());;
                } else {
                    $service->saleUnLock( $orderModel->entrepot, [$model], $request->user());
                }
                
                $model->goods_number = $data['goods_number'];
            }
            
            if ($model->remark != $data['remark']) {
                $model->remark = $data['remark'];
            }
            $re = $model->save();
            if (!$re) {
                throw new \Exception('更新失败');
            } 
            
            $this->updateOrderMoney($orderModel);
            
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }
        
        DB::commit();
        
        return $this->success([]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,InventoryService $service)
    {
        // var_dump($request->all());die();
        DB::beginTransaction();
        try {
            $data = $request->all();
            $model = OrderGoods::create($data);
            $service->saleLock( $model->order->entrepot, [$model], $request->user());
            
            $this->updateOrderMoney(OrderBasic::find($request->input('order_id')));
            
        } catch (Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }
        
        DB::commit();
        return $this->success($model);
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //返回 int
        $goodsModel = OrderGoods::where('id',$id)->select('order_id')->first();
        $orderModel = OrderBasic::find($goodsModel->order_id);
        $orderCheck = $orderModel->isPass();
        if($orderCheck){
            return $this->error([], "审核未通过或未审核不能删除");
        }
        
        $this->updateOrderMoney($orderModel);
        $re = $this->repository->delete($id);
        if ($re) {
            return $this->success([]);
//             return 1;
        } else {
            return $this->error();
//             return 2;
        }
    }
    
    /**
     * 这里有点问题 
     * @param unknown $orderModel
     * @throws \Exception
     */
    private function updateOrderMoney($orderModel)
    {
        $money = OrderGoods::select(DB::raw(' sum( price * goods_number) as m'))->where('order_id', $orderModel->id)->first();
        $orderType = $orderModel->orderType;
//         logger("[dd]", [$orderType->toArray()]);
        $orderModel->order_all_money = $money->m;
        $orderModel->discounted_goods_money =  $orderType->getDiscounted($money->m);
        $orderModel->order_pay_money = $orderModel->discounted_goods_money + $orderModel->freight;
        $re = $orderModel->save();
        if (!$re) {
            throw  new \Exception('更新订单失败');
        }
    }
}
