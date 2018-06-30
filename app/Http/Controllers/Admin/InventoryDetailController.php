<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InventoryDetail;

class InventoryDetailController extends Controller
{
    private $request = null;
    private $model = null;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model = new InventoryDetail();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where = [];
        if ($this->request->has('entrepot_id')) {
            $where[] = ['entrepot_id', $this->request->input('enretpot_id')];
        }
        if ($this->request->has('sku_sn')){
            $where[] = ['sku_sn', $this->request->input('sku_sn')];
        }
        
        if ($this->request->has('goods_name')){
            $where[] = ['goods_name', 'like', $this->request->input('goods_name').'%'];
        }
        
        if ($this->request->has('start')){
            $where[] = ['created', '>=', $this->request->input('start')];
        }
        
        if ($this->request->has('end')){
            $where[] = ['created', '<=', $this->request->input('end')];
        }
        
        if (!empty($where)) {
            $result = $this->model->where($where)->orderby('id','desc')->paginate($this->request->input('pageSize',20));
        } else {
            $result = $this->model->orderby('id','desc')->paginate($this->request->input('pageSize',20));
        }
         
        
        return [
            'items' => $result->items(),
            'total' => $result->total()
        ];
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
