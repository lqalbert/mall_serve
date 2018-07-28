<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogisticsInformation;
use App\Models\ExpressCompany;
use Illuminate\Http\Request;

class LogisticsInformationController extends Controller
{
    public $model=null;
    public function __construct(LogisticsInformation $logisticsInformation)
    {
        $this->model = $logisticsInformation;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('express_id')){
            $express_id = $request->input('express_id');//快递公司ID
            $express_sn = $request->input('express_sn');//快递单号
            $express_eng = ExpressCompany::where('id',$express_id)->value('eng');
            $code = $this->model->where('eng',$express_eng)->value('code');//快宝查询快递公司简称
            $host = "https://kop.kuaidihelp.com/api";
            $method = "POST";
            $headers = array();
            $app_id = '100735';//快宝用户ID
            $api_name = 'express.info.get';
            $app_key = '8db2162259b5d0896c14cc0be57d2dcbcd41a975';//快宝用户中心中的app_key
            $time = time();
            $sign = md5($app_id.$api_name.$time.$app_key);
//根据API的要求，定义相对应的Content-Type
            array_push($headers, "Content-Type".":"."application/x-www-form-urlencoded; charset=UTF-8");
            $querys = "";
            $data = [
              "waybill_no"  => $express_sn,
              "exp_company_code"  => $code,
              "result_sort"  => "0",
            ];
            $bodys = [
                "app_id"=>$app_id,
                "method"=>$api_name,
                "sign"=>$sign,
                "ts"=>$time,
                "data"=>json_encode($data)
//              "data"=>'{ "waybill_no":."800713030656648722", "exp_company_code":."yt","result_sort":"0"}'
            ];

            $bodys = http_build_query($bodys);
            $url = $host;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_FAILONERROR, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            if (1 == strpos("$".$host, "https://"))
            {
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            }
            curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
            $resData = json_decode(curl_exec($curl));
            return get_object_vars($resData);
        }else{
            $this->error([],'没有该快递公司');
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
