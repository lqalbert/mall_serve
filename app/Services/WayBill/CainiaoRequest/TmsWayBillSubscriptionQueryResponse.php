<?php
namespace App\Services\WayBill\CainiaoRequest;

/**
 * <response>
    <success>true</success>
    <errorCode>dsffd</errorCode>
    <errorMsg>dsdsfd</errorMsg>
    <waybillApplySubscriptionCols>
            <waybillApplySubscriptionInfo>
                <branchAccountCols>
                        <waybillBranchAccount>
                            <allocatedQuantity>1</allocatedQuantity>
                            <branchCode>1232</branchCode>
                            <branchName>杭州网点</branchName>
                            <branchStatus>1</branchStatus>
                            <cancelQuantity>23</cancelQuantity>
                            <printQuantity>12</printQuantity>
                            <quantity>32</quantity>
                            <shippAddressCols>
                                    <addressDto>
                                        <detail>文一西路</detail>
                                        <district>余杭区</district>
                                        <city>杭州市</city>
                                        <province>浙江省</province>
                                        <town>仓前街道</town>
                                    </addressDto>
                            </shippAddressCols>
                            <serviceInfoCols>
                                    <serviceInfoDto>
                                        <serviceName>代收货款</serviceName>
                                        <serviceCode>SVC-COD</serviceCode>
                                    </serviceInfoDto>
                            </serviceInfoCols>
                        </waybillBranchAccount>
                </branchAccountCols>
                <cpCode>ZTO</cpCode>
                <cpType>1</cpType>
            </waybillApplySubscriptionInfo>
    </waybillApplySubscriptionCols>
</response>

{
    "success":"true",
    "errorCode":"dsffd",
    "waybillApplySubscriptionCols":[
        {
            "cpCode":"ZTO",
            "cpType":"1",
            "branchAccountCols":[
                {
                    "branchCode":"1232",
                    "quantity":"32",
                    "shippAddressCols":[
                        {
                            "province":"浙江省",
                            "town":"仓前街道",
                            "city":"杭州市",
                            "district":"余杭区",
                            "detail":"文一西路"
                        }
                    ],
                    "allocatedQuantity":"1",
                    "branchStatus":"1",
                    "printQuantity":"12",
                    "serviceInfoCols":[
                        {
                            "serviceCode":"SVC-COD",
                            "serviceName":"代收货款"
                        }
                    ],
                    "branchName":"杭州网点",
                    "cancelQuantity":"23"
                }
            ]
        }
    ],
    "errorMsg":"dsdsfd"
}


 * @author hyf
 *
 */

class TmsWayBillSubscriptionQueryResponse extends MsgResponse
{
    
    /**
     * 可能会返回多个配送的情况
     * @param unknown $xml
     */
    public function xmlSetData($xml)
    {
        $responseList = $xml->waybillApplySubscriptionCols; //$xml->xpath('waybillCloudPrintResponseList');
        $re = [];
        foreach ($responseList->children() as $item) {
            
            $tmp = [
                'branchAccountCols'=> $this->setbranchAccountCols($item->branchAccountCols),
                'cpCode'=>(string)$item->cpCode,
                'cpType'=>(string)$item->cpType,
            ];
            
            $re[] = $tmp;
        }
        $this->data = $re;
    }
    
    
    public function jsonSetData($arr)
    {
        $this->data= $arr['waybillApplySubscriptionCols'];
    }
    
    public function setbranchAccountCols($branch)
    {
        $re = [];
        foreach ($branch->children() as $item) {
            
            $tmp = [
                'allocatedQuantity'=> (string)$item->allocatedQuantity,
                'branchCode'=>(string)$item->branchCode,
                'branchName'=>(string)$item->branchName,
                'branchStatus'=>(string)$item->branchStatus,
                'cancelQuantity'=>(string)$item->cancelQuantity,   
                'printQuantity'=>(string)$item->printQuantity,   
                'quantity'=>(string)$item->quantity,   
                'shippAddressCols'=> $this->setAddress($item->shippAddressCols),
                'serviceInfoCols'=> $item->xpath('serviceInfoCols') ? $this->setService($item->serviceInfoCols) : [],
            ];
            
            $re[] = $tmp;
        }
        return $re;
    }
    
    public function setAddress($addresscal)
    {
        $re = [];
        foreach ($addresscal->children() as $item) {
            $tmp = [
                'detail'=> (string)$item->detail,
                'district'=>(string)$item->district,
                'city'=>(string)$item->city,
                'province'=>(string)$item->province,
                'town'=>(string)$item->town,
            ];
            $re[] = $tmp;
        }
        return $re;
    }
    
    public function setService($service)
    {
        $re = [];
        if ($service->hasChildren()) {
            foreach ($service->children() as $item) {
                $tmp = [
                    'serviceCode'=> (string)$item->serviceCode,
                    'serviceName'=>(string)$item->serviceName,
                ];
                $re[] = $tmp;
            }
        }
        
        return $re;
    }
    
    
}