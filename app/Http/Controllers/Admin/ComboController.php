<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GoodsCombo;

class ComboController extends Controller
{
    
    private $model = null;
    
    public function __construct()
    {
//         parent::__construct();
        
        $this->model = new GoodsCombo();
    }
    
    public function index(Request $request)
    {
        if($request->has('combo_id')) {
            $this->model = $this->model->where('combo_id', $request->input('combo_id'));
        }
        
        //这里打个简省
        return [
            'items' => $this->model->get(),
            'totals' => 0
        ];
    }
    
    public function store(Request $request)
    {
        $model = $this->model->fill($request->all());
        $re = $model->save();
        if ($re) {
            return $this->success($model);
        } else {
            return $this->error([]);
        }
    }
    
    public function update(Request $request, $id)
    {
        $re = $this->model->where('id', $id)->update($request->all());
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }
    
    
    public function destroy(Request $request, $id)
    {
        $re = $this->model->destroy($id);
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }
}
