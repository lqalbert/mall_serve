<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogisticsInformation;
use App\Models\ExpressCompany;
use Illuminate\Http\Request;
use App\Services\LogisticsInformation\LogisticsInformationService;
use App\Models\Assign;
class LogisticsInformationController extends Controller
{
    public $model=null;
    private $service = null;
    private $request = null;

    public function __construct(Request $request,LogisticsInformation $logisticsInformation,LogisticsInformationService $logisticsInformationService)
    {
        $this->request = $request;
        $this->model = $logisticsInformation;
        $this->service = $logisticsInformationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $express_id=null;
        $express_sn=null;
        if($this->request->has('express_id') && $this->request->has('express_sn')){
            $express_id = $this->request->input('express_id');//快递公司ID
            $express_sn = $this->request->input('express_sn');//快递单号
        }else{
            if($this->request->has('order_id')){
                $res = Assign::where('order_id',$this->request->input('order_id'))->first();
                if($res){
                    $express_id = $res->express_id;
                    $express_sn = $res->express_sn;
                }
            }
        }

        if($express_id && $express_sn){
            return  $this->service->get($express_id,$express_sn);
        }else{
            return $this->error([['data']],'该订单还未审核');
        }

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
     * @param  \App\Models\LogisticsInformation  $logisticsInformation
     * @return \Illuminate\Http\Response
     */
    public function show(LogisticsInformation $logisticsInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogisticsInformation  $logisticsInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(LogisticsInformation $logisticsInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogisticsInformation  $logisticsInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogisticsInformation $logisticsInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogisticsInformation  $logisticsInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogisticsInformation $logisticsInformation)
    {
        //
    }
}
