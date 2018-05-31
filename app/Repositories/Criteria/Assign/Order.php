<?php
namespace App\Repositories\Criteria\Assign;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Criteria\Criteria;
use Illuminate\Http\Request;

class Order extends Criteria
{
    private $request= null;
    
    private $price_range = [
        10000,
        20000,
        30000,
        40000
    ];
    
    public function __construct(Request $request)
    {
        
        $this->request = $request;
    }
    
    
    public function  apply($model, RepositoryInterface $repository)
    {
        $request = $this->request;
        $order = [
            'order_sn',
            'price_range', // 0 1 2 3
            'express_remark'
        ];
        return $model->whereHas('order', function($query) use($request){
            if ($request->has('order_sn')) {
                $query->where('order_sn', $request->input('order_sn'));
            }
            if ($request->has('express_remark')) {
                $query->whereNotNull('express_remark');
            }
            if ($request->has('price_range') && $this->price_range[$request->has('price_range')]) {
                $query->where('order_all_money', '>=', $this->price_range[$request->has('price_range')]);
            }
        });
    }
}