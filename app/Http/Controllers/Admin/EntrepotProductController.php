<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Inventory;
use App\Models\Goods;
use App\Models\InventorySystem;
use App\Models\DistributionCenter;
use App\Models\GoodsCombo;
use App\Services\Inventory\InventoryService;
use Illuminate\Support\Facades\DB;

class EntrepotProductController extends Controller
{   
    /**
     * 获取仓库里面的商品可销售的数量
     * 
     * @param Request $request
     * @param String sku_sn
     * 
     * @return int
     */
    public function getEntrepotProductCount(Request $request, $sku_sn)
    {
        $user= auth()->user();
        if (empty($user->department_id)) {
            return ['num'=>0];
        }
        
        if (empty($user->department->entrepot_id)) {
            return ['num'=>0];
        }
        
        $inventorySystem = new Inventory();
        
        //先查一下是不是套餐
        $goodsModels = Goods::where('sku_sn', $sku_sn)->first();
        $re = $inventorySystem->getProductCount($user->department->entrepot_id, $sku_sn);
        return ['num'=>$re];  
    }
    
    
    /**
     * 套装 商品详情那里使用
     */
    public function ComboCount(Request $request, $sku_sn)
    {
        //所有的仓库
        $entrepots=    DistributionCenter::all(['id','name']);
        
        foreach ($entrepots as &$item) {
            $item->sku_sn = $sku_sn;
            $item->entrepot_count = 0;
            $item->saleable_count = 0;
        }
        
        $entrepot_ids = $entrepots->pluck('id');
        if ($entrepot_ids) {
            $re = InventorySystem::where('sku_sn', $sku_sn)->whereIn('entrepot_id', $entrepot_ids)->get();
            if ($re) {
                $entrepotSkusn = $re->keyBy('entrepot_id');
                foreach ($entrepots as &$item) {
                    if ($entrepotSkusn->has($item->id)) {
                        $tmp = $entrepotSkusn->get($item->id);
                        $item->entrepot_count = $tmp->entrepot_count;
                        $item->saleable_count = $tmp->saleable_count;
                    }
                }
            }
        }
        return ['items'=>$entrepots];
    }
    
    
    /**
     * 添加套装
     */
    public function addCombo(Request $request, InventoryService $serve)
    {
        $entrepot_id = $request->input('entrepot_id');
        $combo_id = $request->input('combo_id');
        $num = intval($request->input('num'));
        
        $comboGoods = GoodsCombo::with(['goods'=> function($query){
            $query->select('id','sku_sn');
        }])->where('combo_id', $combo_id)->get();
        
        if (!$comboGoods) {
            return $this->error([],"没有商品");
        }
        if ($num > 0) {
            $on = true;
        } else if($num != 0) {
            $on = false;
        } else {
            return $this->error([], '数量不能为0');
        }
        
        $num = abs($num);
        foreach ($comboGoods as &$goods) {
            $goods->num = $goods->num * $num;
        }
        $combo = Goods::find($combo_id);
        $combo->combo_num = $num;
        
        $entrepot = DistributionCenter::find($entrepot_id);
        logger("[combogoods]", $comboGoods->toArray());
        DB::beginTransaction();
        try {
            $serve->combo($entrepot, [$combo], auth()->user(), $on);
            $serve->comboGoods($entrepot, $comboGoods, auth()->user(), !$on);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }
        return $this->success([]);        
    }
    
    
    public function idnex()
    {
        
    }
}
