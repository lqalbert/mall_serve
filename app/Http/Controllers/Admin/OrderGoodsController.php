<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\OrderGoods;
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
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $model = OrderGoods::create($data);
            
            $deta_num = $model->getNum() - $data['goods_number'];
            $service->saleLock( $order->entrepot, $model, $request->user());
            
        } catch (Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }
        
        DB::commit();
        //throw new \Exception('test');
//         $re = $this->repository->create($request->input());
        if ($re) {
            return $this->success($re);
        } else {
            return $this->error($re);
        }
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
