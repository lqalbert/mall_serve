<?php
namespace App\Services\WayBill\CainiaoRequest;

/**
 * <response>
    <success>false</success>
    <errorCode>dsffd</errorCode>
    <errorMsg>dsdsfd</errorMsg>
    <waybillCloudPrintResponseList>
            <waybillCloudPrintResponse>
                <objectId>12</objectId>
                <waybillCode>9890000160004</waybillCode>
                <printData>json串</printData>
            </waybillCloudPrintResponse>
    </waybillCloudPrintResponseList>
</response>

{
    "success":"false",
    "errorCode":"dsffd",
    "waybillCloudPrintResponseList":[
        {
            "waybillCode":"9890000160004",
            "printData":"json串",
            "objectId":"12"
        }
    ],
    "errorMsg":"dsdsfd"
}

 * @author hyf
 *
 */
class TmsWayBillGetResponse extends MsgResponse
{
    
    private $ResonseData = null;
    private $type = "json";
    
    public function setParam($data, $type)
    {
        $this->ResonseData = $data;
        $this->type = $type;
    }
    
    /**
     * 处理数据
     * @return mixed
     */
    public function deal()
    {
        if ($this->type == 'xml') {
            $this->xmlSetAll($this->ResonseData);
        } else {
            $this->jsonSetAll($this->ResonseData);
        }
    }
    
    public function xmlSetAll($xml)
    {
        $this->xmlSetStatus($xml);
        if ($this->isSuccess()) { //成功需要设置返回数据 失败不需要
            $this->xmlSetData($xml);
        } else {
            $this->msg = $this->xmlSetMsg($xml);
        } 
    }
    
    public function xmlSetData($xml)
    {
        $responseList = $xml->waybillCloudPrintResponseList; //$xml->xpath('waybillCloudPrintResponseList');
        $re = [];
        foreach ($responseList->children() as $item) {
            $tmp = [
                'objectId'=>(string)$item->objectId,
                'waybillCode'=>(string)$item->waybillCode,
                'printData'=>(string)$item->printData,
            ];
            
            $re[] = $tmp;
        }
        $this->data = $re;
    }
    
    public function xmlSetMsg($xml)
    {
        $msg = $xml->errorMs;//$xml->path('/response/errorMsg');
        $this->msg= $msg;
    }
    
    public function jsonSetAll()
    {
        //未完成
    }
    
    
    
    
}