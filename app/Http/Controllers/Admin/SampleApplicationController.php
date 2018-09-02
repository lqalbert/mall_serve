<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SampleBasic;
use App\Models\SampleGoods;
use App\Models\GoodsDetails;
use App\Services\Inventory\InventoryService;
use App\Models\DistributionCenter;

class SampleApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new SampleBasic;

        if ($request->has('start')) {
            $model = $model->where('app_time','>=',$request->input('start'));
        }

        if ($request->has('end')) {
            $model = $model->where('app_time','<=',$request->input('end'));
        }

        if ($request->has('applicant')) {
            $model = $model->where('applicant',$request->input('applicant'));
        }

        if($request->has('check_status')){
            $model = $model->where('check_status', $request->input('check_status'));
        }

        $result = $model->paginate($request->input('pageSize', 15));
        $collection = $result->getCollection();
        $collection->load('goods'); //'goods',

        $re = $collection->toArray();
        
        return [
            'items'=>$re,
            'total'=> $result->total()
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
        DB::beginTransaction();
        try {
            $allData = $request->all();
            $sampleModel = SampleBasic::make($allData);
            $re = $sampleModel->save();
            if (!$re) {
                throw new  \Exception('样品申请创建失败');
            }

            $GoodsModels = [];
            foreach ($request->goodsData as $goods) {
                $goods['unit_type'] = GoodsDetails::getUnitTypes($goods['unit_type']);
                $GoodsModels[] = SampleGoods::make($goods);
            }
            
            if (!empty($GoodsModels)) {
                $sampleModel->goods()->saveMany($GoodsModels);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }

        return $this->success([]);

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
    public function update(Request $request, InventoryService  $serve,  $id)
    { 
        DB::beginTransaction();
        try {
            $data = [
                'check_time'=>Carbon::now(),
                'check_status'=>$request->check_status,
                'check_remark'=>$request->check_remark
            ];
            $re = SampleBasic::where('id',$id)->update($data);
            if(!$re){
                throw new  \Exception('审核失败');
            }

            if(!empty($request->input('del_ids'))){
                $res = SampleGoods::destroy($request->input('del_ids'));
                if (!$res) {
                    throw new  \Exception('删除商品失败');
                }
            }

            //以下扣库存 商品数量可以从$request->goods里面获得
            $goods = $request->goods;
            $products = [];
            foreach ($goods as $item) {
                $products[] = SampleGoods::findOrFail($item->id);
            }
            
            $serve->smaple(DistributionCenter::find(3), $products, auth()->user());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return  $this->error([], $e->getMessage());
        }
        return $this->success([]);

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
