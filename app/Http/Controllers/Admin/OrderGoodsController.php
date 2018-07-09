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
            $orderCheck = OrderBasic::find($request->order_id)->isPass();
            if(!$orderCheck){
                return $this->error([], "审核未通过或未审核不能更新");
            }

            $data = $request->all();
            $model = OrderGoods::findOrFail($id);
            
            $deta_num = $model->getNum() - $data['goods_number'];
            if ($deta_num != 0) {
                $model->goods_number = $deta_num;
                $service->saleLock( $model->order->entrepot, [$model], $request->user());
                $model->goods_number = $data['goods_number'];
            }
            
            if ($model->remark != $data['remark']) {
                $model->remark == $data['remark'];
            }
            $model->save();
        } catch (Exception $e) {
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

            $deta_num = $model->getNum() - $data['goods_number'];
            $service->saleLock( $model->order->entrepot, [$model], $request->user());
            
        } catch (Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }
        
        DB::commit();
        return $this->success([]);
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
        $orderModel = OrderGoods::where('id',$id)->select('order_id')->first();
        $orderCheck = OrderBasic::find($orderModel->order_id)->isPass();
        if(!$orderCheck){
            return $this->error([], "审核未通过或未审核不能删除");
        }

        $re = $this->repository->delete($id);
        if ($re) {
            //return $this->success(1);
            return 1;
        } else {
            //return $this->error();
            return 2;
        }
    }
}
