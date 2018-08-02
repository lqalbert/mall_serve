<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mail;
use Illuminate\Http\Request;
use App\Services\WayBill\WayBillService;
use App\Services\WayBill\MsgType\TmsWayBillGet;
use App\Services\WayBill\MsgType\TmsWayBillGet2;
use App\Models\ExpressCompany;

class MailController extends Controller
{
    public $model = null;

    public function __construct(Mail $mail)
    {
        $this->model = $mail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if ($request->has('start')) {
            $where[]=['created_at','>=',$request->input('start').' 00:00:00'];
        }
        if ($request->has('end')) {
            $where[]=['created_at','<=',$request->input('end').' 23:59:59'];
        }
        if ($request->has('type')) {
            $where[]=['type','=',$request->input('type')];
        }
        if ($request->has('express_sn')) {
            $where[]=['express_sn','=',$request->input('express_sn')];
        }
        $data = $this->model->where($where)
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('pageSize'));
        return ['items' => $data->items(), 'total' => $data->total()];
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
        $data = $request->all ();
        // DD($data);
        $re = $this->model->create ( $data );
        if ($re) {
            return $this->success ( [] );
        } else {
            return $this->error ( [] );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function show(mail $mail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function edit(mail $mail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $re = $this->model->where('id','=',$id)->update($request->all());
        if ($re) {
            return $this->success ( [] );
        } else {
            return $this->error ( [] );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $re =  $this->model->destroy($id);
        if ($re) {
            return $this->success ( [] );
        } else {
            return $this->error ( [] );
        }
    }
    
    public function getWaybillCode(Request $request, WayBillService $service)
    {
        $ids = $request->input('ids');
        $express_id = $request->input("express_id");
        $mais = $this->model->whereIN('id', $ids)->get();
        
        $express = ExpressCompany::find($express_id);
        
        $cmd = new TmsWayBillGet2(); 
        $cmd->setParam($mais, $express, auth()->user()->id);
        $re =  $service->send($cmd);
        
        if ($re['status'] == 1) { //成功
            $cainiodata = $re['data'];
            if (count($cainiodata) == 0) {
                return $this->error([],'面单获取失败:数量为0');
            }
            foreach ($cainiodata as $item) {
                Mail::where('id', $item['objectId'])->update(['express_sn'=> $item['waybillCode'], 'print_data'=> $item['printData'],'express_id'=>$express->id, 'express_name'=>$express->company_name]);
            }
            
            return $this->success();
        } else {
            return $this->error([], '面单获取失败:'.$re['msg']);
        }
    }
    
    /**
     * 面单打印
     * @todo 事件处理　操作记录
     * 打印
     */
    public function waybillPrint(Request $request)
    {
        $mails = $this->model->whereIn('id', $request->input('ids'))->select('express_id','print_data')->get();
        $mail = $mails->first();
        $express = $mail->express;
        if ($mails) {
            return $this->success(['printer'=>$express->printer,'print_data'=>$mails->pluck('print_data')]);
        } else {
            return $this->error([]);
        }
    }
}
