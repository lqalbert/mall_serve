<?php
namespace App\Repositories\Criteria\Assign;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Criteria\Criteria;
use App\Models\Goods as GoodsBasic; 

class Goods extends Criteria 
{
    private $request= null;
   
    
    public function __construct(Request $request)
    {
        
        $this->request = $request;
    }
    
    
    public function  apply($model, RepositoryInterface $repository)
    {
        $request = $this->request;
        $cates = $request->input('cate_ids');
        $goods = GoodsBasic::whereHas('midCate', function($query) use($cates) {
            $query->where('cate_id', $cates[count($cates)-1]);
        })->pluck('id');
        
        if ($goods->isEmpty()) {
            $goods = collect(['0']);
        }
        
        return $model->whereHas('goods', function($query) use($goods){
            if ($goods) {
                $query->whereIn('goods_id', $goods);
            } 
        });
    }
}