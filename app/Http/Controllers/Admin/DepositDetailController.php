<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DepositDetail;
use App\Alg\ModelCollection;

class DepositDetailController extends Controller
{
    private $model = null;
    
    public function  __construct(DepositDetail $model)
    {
        $this->model = $model;
    }
    
    public function index(Request $request)
    {
        $model = $this->model->where('order_id', $request->order_id);

        $re = $model->orderBy('type','asc')->get();
        
        if ($request->has('append')) {
            $re = ModelCollection::setAppends($re, $request->input('append'));
        }
        
        return [
            'items' => $re,
            'total' => $re->count()
        ];
    }
}
