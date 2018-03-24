<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assign;
use App\Models\ProduceEntry;
use App\Models\ProduceEntryProduct;
use App\Models\BadGoods;
use Illuminate\Http\Request;
use App\Models\InventorySystem;
use App\Models\OrderGoods;

class InventoryGatherController extends Controller
{
    
    public function index(Request $request)
    {
        
        $fields = [
            'id',
            'entrepot_id',
            'goods_name',
            'sku_sn',
           
            'entrepot_count',
            'saleable_count'
        ];
        
        $model = new InventorySystem();
        
        if ($request->has('entrepot_id')) {
            $model->where('entrepot_id', $request->input('entrepot_id'));
        }
        
        if ($request->has('goods_name')) {
            $model->where('goods_name', 'like', $request->input('goods_name'));
        }
        
        if ($request->has('cate_kind_id')) {
            $cate_kind_id = $request->input('cate_kind_id');
            $model = $model->wherehas('goods', function($query){
                $query->where('cate_kind_id', $cate_kind_id);
            });
        } else if($request->has('cate_type_id')) {
            $cate_type_id = $request->input('cate_type_id');
            $model = $model->wherehas('goods', function($query) use($cate_type_id) {
                $query->where('cate_type_id', $cate_type_id);
            });
        }
       
//         $model->with(['goods','entrepot']);
//         $model->setVisible(['goods']);
        
        $result = $model->paginate($request->input('pageSize', 20), $fields);
        
        $collection = $result->getCollection();
        $collection->load('goods', 'entrepot');
        
        $re = $collection->toArray();
        
        $range = [];
        if($request->has('start') && $request->has('end')) {
            $range[] = $request->input('start');
            $range[] = $request->input('end');
        }
        
        
       /*  //出库数量
        Assign;
        //累记入库数量
        ProduceEntryProduct;
        //累记损坏数量
        BadGoods; */
        
        $this->getAssign($re, $range);
        
        return [
            'items'=>$re,
            'total'=> $result->total()
        ];
    }
    
    
    private function setRange($rang, $field) 
    {
        return [
            [$field, '>=', $range[0]],
            [$field, '<=', $range[1]]
        ];
    }
    
    //累记出库数量
    //累记入库数量
    //累记损坏数量
    public function getAssign(&$re, $range)
    {
        foreach ($re as $key => &$goods) {
            //累记出库数量
            $Assignwhere =[
                ['entrepot_id', $goods['entrepot_id']],
                ['sku_sn', $goods['sku_sn']],
                ['status', 1]
            ];
            
            if (!empty($range)) {
                $Assignwhere = array_merge($Assignwhere, $this->setRange($re, 'out_entrepot_at'));
            }
            $goods['entrepot_out'] = Assign::where($Assignwhere)->count();
            
            //累记入库数量
            $proWhere = [
                ['sku_sn', $goods['sku_sn']],
            ];
            if (!empty($range)) {
                $proWhere= array_merge($proWhere, $this->setRange($re, 'created_at'));
            }
            $model = ProduceEntryProduct::where($proWhere);
            $entrepot_id = $goods['entrepot_id'];
            $goods['entrepot_id'] = $model->whereHas('produceEntry', function($query) use($entrepot_id) {
                $query->where('entrepot_id', $entrepot_id);
            })->count();
            
            //累记损坏数量
            $badWhere = [
                ['entrepot_id', $goods['entrepot_id']],
                ['sku_sn', $goods['sku_sn']],
            ];
            if (!empty($range)) {
                $badWhere= array_merge($badWhere, $this->setRange($re, 'created_at'));
            }
            $goods['bad_num'] = BadGoods::where($badWhere)->count();
            
        }
    }
    
    public function detail(Request $request)
    {
        $fields = [
            'id',
            'entrepot_id',
            'goods_name',
            'sku_sn',
            'entrepot_count',
        ];
        
        $model = new InventorySystem();
        
        if ($request->has('entrepot_id')) {
            $model->where('entrepot_id', $request->input('entrepot_id'));
        }
        
        if ($request->has('goods_name')) {
            $model->where('goods_name', 'like', $request->input('goods_name'));
        }
        
        if ($request->has('cate_kind_id')) {
            $cate_kind_id = $request->input('cate_kind_id');
            $model = $model->wherehas('goods', function($query){
                $query->where('cate_kind_id', $cate_kind_id);
            });
        } else if($request->has('cate_type_id')) {
            $cate_type_id = $request->input('cate_type_id');
            $model = $model->wherehas('goods', function($query) use($cate_type_id) {
                $query->where('cate_type_id', $cate_type_id);
            });
        }
        
        $result = $model->paginate($request->input('pageSize', 20), $fields);
        
        $collection = $result->getCollection();
        $collection->load('entrepot');
        
        $re = $collection->toArray();
        
        $range = [];
        if($request->has('start') && $request->has('end')) {
            $range[] = $request->input('start');
            $range[] = $request->input('end');
        }
        
        
        ///生产入库数量	
        //退货入库数量	 
        //销售锁定数	order_goods  created_at
        //发货锁定数	assign_basic created_at
        //换货锁定数  还没有
        
        $this->getSte($re, $range);
        logger($re);
        return [
            'items'=> $re,
            'total'=> $result->total()
        ];
        
    }
    
    private function getSte(&$re ,$range) {
        foreach ($re as &$goods) {
            //生产入库数量	
            $proWhere = [
                ['sku_sn', $goods['sku_sn']],
            ];
            if (!empty($range)) {
                $proWhere= array_merge($proWhere, $this->setRange($re, 'created_at'));
            }
            $model = ProduceEntryProduct::where($proWhere);
            $entrepot_id = $goods['entrepot_id'];
            $goods['entrepot_in'] = $model->whereHas('produceEntry', function($query) use($entrepot_id) {
                $query->where('entrepot_id', $entrepot_id);
            })->count();
            
            //退货入库数量
            $returnWhere = [
                ['entrepot_id', $goods['entrepot_id']],
                ['sku_sn', $goods['sku_sn']],
            ];
            if (!empty($range)) {
                $returnWhere= array_merge($returnWhere, $this->setRange($re, 'created_at'));
            }
            $goods['return_num'] = BadGoods::where($returnWhere)->count();
            
            //销售锁定数
            $orderWhere =[
                ['sku_sn', $goods['sku_sn']],
            ];
            
            if (!empty($range)) {
                $orderWhere = array_merge($orderWhere, $this->setRange($re, 'created_at'));
            }
            $model = OrderGoods::where($orderWhere);
            $goods['order_lock'] = $model->whereHas('order', function($query) use($entrepot_id) {
                $query->where('entrepot_id', $entrepot_id);
            })->count();
            
            //发货锁定数
            $Assignwhere =[
                ['entrepot_id', $goods['entrepot_id']],
                ['sku_sn', $goods['sku_sn']],
                ['status', 1]
            ];
            
            if (!empty($range)) {
                $Assignwhere = array_merge($Assignwhere, $this->setRange($re, 'created_at'));
            }
            $goods['assign_lock'] = Assign::where($Assignwhere)->count();
            
            //换货锁定数  还没有
            $goods['exchange_lock'] = 0;
        }
        
    }
    
    
}