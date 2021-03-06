<?php
namespace App\Services\WayBill\MsgType;

/**
 * 查看文档
 * http://pac.i56.taobao.com/apiinfo/showDetail.htm?spm=0.0.0.0.wHMfPP&apiId=TMS_WAYBILL_SUBSCRIPTION_QUERY&type=merchant_electronic_sheet
 * 这个文档主要是为了用来获取发货地址的．
 * 需要保存
 * @author hyf
 *
 */
class TmsWayBillSubscriptionQuery
{
    
    private $data = [
        'cpCode'=>''
    ];
    
    public function setParam(array $param)
    {
        $this->data = array_merge($this->data, $param);
    }
    
    public function setDataType($dataType)
    {
        
    }
    
    public function getContent($dataType)
    {
//         logger('xml', [$dataType]);
        if ($dataType == 'xml') {
            return $this->toXml($this->data);
        } else {
            return json_encode($this->data);
        }
    }
    
    public function toXml($data)
    {
        $xml = simplexml_load_string('<request></request>');
        
        $xml->addChild('cpCode', $data['cpCode']); 
        
        return $xml->saveXML();
    }
    
    public function getToCode()
    {
        return '';
    }
    
    final public function  getApi()
    {
        return 'TMS_WAYBILL_SUBSCRIPTION_QUERY';
    }
}