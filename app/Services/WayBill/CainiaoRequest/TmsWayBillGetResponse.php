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
    
    public function jsonSetData($arr)
    {
        $this->data = $arr['waybillCloudPrintResponseList'];
    }    
    
}
