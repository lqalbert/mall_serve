<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Inventory;
use App\Models\Goods;

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
        if (!$goodsModels->isThisACombo()) {
            //不是
            $re = $inventorySystem->getProductCount($user->department->entrepot_id, $sku_sn);
            return ['num'=>$re];
        } else {
            //是
            logger("[xx]",['aaa']);
            $combos = $goodsModels->combos;
            $combos->load('goods');
            logger("[xx]",$combos->toArray());
            foreach ($combos as &$item) {
                $re = $inventorySystem->getProductCount($user->department->entrepot_id, $item->goods->sku_sn);
                if ($re == 0) {
                    return ['num'=>$re];
                }
                $item->goods->price = $item->price;
                $item->goods->goods_number = $item->num;
            }
            
            return [
                'num'=>1,
                'goods'=> $combos->pluck('goods')
            ];
        }
        
        
    }
    
    
    public function idnex()
    {
        
    }
}
