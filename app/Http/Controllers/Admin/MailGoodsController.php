<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MailGoods;

class MailGoodsController extends Controller
{
    
    private $model = null;
    public function __construct(MailGoods $model)
    {
        $this->model = $model;
    }
    
    public function index(Request $request)
    {
        $where=  [];
        
        if ($request->input('mail_id')) {
            $where[] = [ 'mail_id', $request->input('mail_id')];
        }
        
        $data = $this->model->where($where)
        ->orderBy('created_at', 'desc')
        ->paginate($request->input('pageSize',10));
        
        return ['items' => $data->items(), 'total' => $data->total()];
    }
    
    public function store(Request $request)
    {
        $data = $request->all ();
        // DD($data);
        $re = $this->model->create ( $data );
        if ($re) {
            return $this->success ( [] );
        } else {
            return $this->error ( [] );
        }
        
    }
    
    public function update(Request $request, $id)
    {
        $re = $this->model->where('id','=',$id)->update($request->all());
        if ($re) {
            return $this->success ( [] );
        } else {
            return $this->error ( [] );
        }
    }
    
    public function destroy(Request $request, $id)
    {
        $re =  $this->model->destroy($id);
        if ($re) {
            return $this->success ( [] );
        } else {
            return $this->error ( [] );
        }
    }
}
