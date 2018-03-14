<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProduceEntry;
use App\Models\ProduceEntryProduct;
use App\Models\OrderGoods;
use Illuminate\Support\Facades\DB;

class ProduceEntryController extends Controller
{


    private $parentModel = null;
    private $childModel = null;

    public function  __construct(ProduceEntry $ProduceEntry,ProduceEntryProduct $ProduceEntryProduct)
    {
        $this->parentModel = $ProduceEntry;
        $this->childModel = $ProduceEntryProduct;

    }

    public function store(Request $request)
    {

//        $p_data['user_name'] = $request->input('user_name');
//        $p_data['user_id'] = $request->input('user_id');
//        $p_data['entrepot_id'] = $request->input('entrepot_id');
//        $p_data['comment'] = $request->input('comment');
//        $p_data['entry_at'] = $request->input('entry_at');
//        $p_data = $request->input('parentData');

        $p_data = $request->input('parentData');
        $re = $this->parentModel->create($p_data);

        $parent_id = $re->id;
        $time = $re->created_at;
//        var_dump($re->id);die();
//        $c_data['parent_id'] = $this->parentModel->id;
//        $c_data['cate_type'] = $request->input('cate_type');
//        $c_data['cate_kind'] = $request->input('cate_kind');
//        $c_data['cate_type_id'] = $request->input('cate_type_id');
//        $c_data['cate_kind_id'] = $request->input('cate_kind_id');
//        $c_data['product_sale_type'] = $request->input('product_sale_type');
//        $c_data['goods_name'] = $request->input('goods_name');
//        $c_data['sku_sn'] = $request->input('sku_sn');
//        $c_data['num'] = $request->input('num');

        $c_data=[];
        foreach ($request->input('childrenData') as $k => $v){
            $v['parent_id'] = $parent_id;
            $v['created_at'] = $time;
            $v['updated_at'] = $time;
            $c_data[$k] = $v;
        }

        $this->childModel->insert($c_data);

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