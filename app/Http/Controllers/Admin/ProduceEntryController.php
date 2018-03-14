<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProduceEntry;
use App\Models\ProduceEntryProduct;

use Illuminate\Support\Facades\DB;

use App\Models\OrderGoods;


class ProduceEntryController extends Controller
{

    public function store(Request $request)
    {
        
        DB::beginTransaction();
        try {
            $model = ProduceEntry::create($request->except('childrenData'));
            $products = $request->input('childrenData', []);
            $productsModels = [];
            foreach ($products as $product) {
                $productsModels[] = new ProduceEntryProduct($product);
            }
            if (!empty($productsModels)) {
                $model->products()->saveMany($productsModels);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->error([]);
        }

        return $this->success([]);
    }

//    获取销售锁定展示数据
    public function GetSaleLockData(){
        $order_model = new OrderGoods();

       $saleLockData = $order_model
           ->join('order_basic','order_goods.order_id','=','order_basic.id')
           ->join('delivery_addresses','order_basic.address_id','=','delivery_addresses.id')
           ->join('user_basic','order_basic.deal_id','=','user_basic.id')
           ->join('department_basic','user_basic.department_id','=','department_basic.id')
           ->join('group_basic','user_basic.group_id','=','group_basic.id')
           ->select(DB::raw("concat(concat(department_basic.name,'-',group_basic.name),'-',user_basic.realname) as sale_name"),"order_goods.goods_name","order_goods.goods_number as sale_number","delivery_addresses.name as customer_name",'order_basic.check_status as examine_status','order_goods.created_at as sale_lock_time')
           ->get();
        return ['items'=>$saleLockData,'total'=>count($saleLockData)];

    }
    
}