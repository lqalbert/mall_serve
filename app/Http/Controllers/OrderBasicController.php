<?php

namespace App\Http\Controllers;

use App\models\OrderBasic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderBasicController extends Controller
{


    private $model = null;
    public function  __construct(OrderBasic $OrderBasic)
    {
        $this->model = $OrderBasic;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $fields=['order_basic.id','order_basic.cus_id','order_basic.goods_name','order_basic.category_id','order_basic.goods_number','order_basic.remark'];
        $data=$this->model
            ->where('cus_id','=',$request->cus_id)
            ->select($fields)
            ->get();
        foreach ($data as $k => $v){
            $cat_ids=explode(',',$v['category_id']);
            $category_names=DB::table('category_base')->whereIn('id',$cat_ids)->select('label')->get();
            $dev=[];
            foreach ($category_names as $k1 => $v1){
               $dev[]=$v1->label;
            }
            $data[$k]['category_name']=implode('/',$dev);
        }

        return ['items'=>$data];
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
        $this->model->cus_id = $request->cus_id;
        $this->model->goods_id = $request->goods_id;
        $this->model->goods_name = $request->goods_name;
        $this->model->category_id = $request->category_id;
        $this->model->goods_number = $request->goods_number;
        $this->model->remark = $request->remark;
        $this->model->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\OrderBasic  $orderBasic
     * @return \Illuminate\Http\Response
     */
    public function show(OrderBasic $orderBasic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\OrderBasic  $orderBasic
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderBasic $orderBasic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\OrderBasic  $orderBasic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderBasic $orderBasic,$id)
    {
        $data=[
            'cus_id'=>$request->cus_id,
            'goods_id'=>'1',//暂时未关联goods表
            'goods_name'=>$request->goods_name,
            'category_id'=>$request->category_id,
            'goods_number'=>$request->goods_number,
            'remark'=>$request->remark,
        ];
        $this->model->where('id','=',$id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\OrderBasic  $orderBasic
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderBasic $orderBasic,$id)
    {
        $this->model->destroy($id);
    }
}
