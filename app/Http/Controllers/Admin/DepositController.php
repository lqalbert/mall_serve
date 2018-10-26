<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Deposit;
use Monolog\Handler\IFTTTHandler;
use PhpParser\Node\Stmt\If_;
use App\models\OrderBasic;
use App\Events\OrderPass;
use Illuminate\Support\Facades\DB;
use Psy\Exception\ThrowUpException;
use App\Services\DepositOperation\DepositOperationService;
use App\Models\Department;
use App\Models\DepositSet;
use App\Alg\ModelCollection;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where=[];
    	if($request->has('department_id')){
            $where[]=['department_id','=',$request->input('department_id')];
        }
        
        if ($request->has('start') && $request->has('end')) {
            $where[]=['charge_time','>=',$request->input('start')];
            $where[]=['charge_time','<=',$request->input('end')];
        }
        
        
        
        $page = Deposit::where($where)->orderBy('id', 'desc')->paginate($request->input('pageSize', 20));
        $collection = $page->getCollection();
        if ($request->has('append')) {
            $collection = ModelCollection::setAppends($collection, $request->input('append'));
        }
        
        
    	return [
    	    'items'=> $collection,
			'total'=> $page->total(),
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
    public function store(Request $request, DepositOperationService $service)
    {
        $department = Department::find($request->input('department_id'));
        try {
            $service->addDeposit($department,  $request->input('money'), $request->input('remark',null));
        } catch (Exception $e) {
            return $this->error([], $e->getMessage());
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
    public function update(Request $request, $id)
    {
        
        $re = Deposit::where('id', $id)->update($request->all());
        if ($re) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
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
    
    private function checkOrder($department_id)
    {
        $re = OrderBasic::where([
            ['status', OrderBasic::WATI_TO_CHANGR],
            ['department_id', $department_id]
        ])->get();
        DB::beginTransaction();
        try {
            foreach ($re as $value) {
                event(new OrderPass($value, $value->auditor));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error([], '有部分订单扣款失败，请联系开发人员');
        }
    }

    /**
     * [revoke 保证金撤销]
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function revoke(Request $request,$id){
        DB::beginTransaction();
        try {
            $model = Deposit::find($id);
            $result = $model->increment('revoke_status');
            if(!$result){
                throw new \Exception("撤销失败");
            }
            $department = $model->department;
            $department->subDeposit($request->money);
            $re = $department->save();
            if (!$re) {
                throw new \Exception('更新部门保证金失败');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->error([], $e->getMessage());
        }
        return $this->success([]);
    }
    
    
    /**
     * 保证金设置
     */
    public function setDeposit(Request $request)
    {
        $model = DepositSet::getInstance();
        $model->fill($request->all());
        if ($model->save()) {
            return $this->success([]);
        } else {
            return $this->error([]);
        }
    }
    
    /**
     * 获取设置 
     */
    public function getDepositSet()
    {
        return $this->success(DepositSet::getInstance());
    }







}
