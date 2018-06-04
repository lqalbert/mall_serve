<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assign;

class WayBillController extends Controller
{
    public function __construct(Request $request)
    {  
       $this->request  = $request; 
    }
    
    public function getOne($assign_id, $express_id, $order_id)
    {
        //判断一下是　全新的　还是　更新
        $assign = Assign::select(['express_id','express_sn'])->findOrFail($assign_id);
        if ($assin->express_id !=  $express_id) { //全新的
            ;
        } else {
            //更新的
        }
    }
    
    
}
