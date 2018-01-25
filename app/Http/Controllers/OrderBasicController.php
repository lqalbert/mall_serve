<?php

namespace App\Http\Controllers;

use App\models\OrderBasic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\OrderlistRepository;
use App\Services\Orderlist\OrderlistService;
class OrderBasicController extends Controller
{


    private $model = null;
    private $repository = null;
    public function  __construct(OrderBasic $OrderBasic,OrderlistRepository $repository)
    {
        $this->model = $OrderBasic;
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business = $request->query('business', 'default');
        switch ($business){
            case 'Orderlist':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get();
                break;
            case 'select':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get();
                break;
            default:
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get();
        }
        return $result;
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
        $this->model->deal_id = $request->deal_id;
        $this->model->deal_name = $request->deal_name;
        $this->model->address_id = $request->address_id;
        $this->model->order_all_money = $request->order_all_money;
        $this->model->order_pay_money = $request->order_pay_money;
        $this->model->save();
        $order_id=$this->model->id;
        $orderGoods=$request->order_goods;
        $data=[];
        foreach ($orderGoods as $k => $v){
            $v['order_id'] = $order_id;
            unset($v['moneyNotes']);
            $data[$k]=$v;
        }
        DB::table('order_goods')->insert($data);
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
        $re = $this->repository->update($request->input(), $id);
        if ($re) {
            return $this->success(OrderBasic::find($id));
            //return 1;
        } else {
            return $this->error();
            //return 2;
        }
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
