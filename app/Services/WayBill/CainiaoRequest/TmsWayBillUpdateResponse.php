<?php
namespace App\Services\WayBill\CainiaoRequest;

/**
 * <response>
    <success>false</success>
    <errorCode>dsffd</errorCode>
    <errorMsg>dsdsfd</errorMsg>
    <waybillCode>x</waybillCode>
    <printData>fgfhjlk</printData>
</response>

{
    "success":"false",
    "errorCode":"dsffd",
    "waybillCode":"x",
    "printData":"fgfhjlk",
    "errorMsg":"dsdsfd"
}


 * @author hyf
 *
 */
class TmsWayBillUpdateResponse extends MsgResponse
{
    
   

    public function xmlSetData($xml)
    {
        $re = [
            'waybillCode' => (string)$xml->waybillcode,
            'printDate'   => (string)$xml->printData
        ];
        $this->data = $re;
    }
    
    
    
    public function jsonSetData($arr)
    {
        //$xml->waybillCloudPrintResponseList; //$xml->xpath('waybillCloudPrintResponseList');
        $this->data= [
            'waybillCode' => $arr['waybillCode'],
            'printDate'  => $arr['printDate']
        ];
    }
    
    
    
    
    
    
}