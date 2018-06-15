<?php
namespace App\Services\WayBill\MsgType;

/**
 * 生成如下连接结构的数据
 * 有误　应该是更新哪些数据就传哪些数据
 * http://pac.i56.taobao.com/apiinfo/showDetail.htm?spm=0.0.0.0.9fnYWG&apiId=TMS_WAYBILL_UPDATE&type=merchant_electronic_sheet
 * @author hyf
 *
 */
class TmsWayBillUpdate
{
    private $data = [
        'cpCode'=>'',
        'waybillCode'=>'',
        'packageInfo'=>null,
        'recipient'=>null,
        'sender'=>null,
        'templateUrl'=>""
    ];
    
    
    public function setParam($assign, $express, $order)
    {
        $data = [
            'cpCode' => $express->eng,
            'waybillCode' => $assign->express_sn,
            'packageInfo' => $this->getpackageInfo($assign->id, $order->goods),
            'recipient'   => $order->getRecipient(),
            'sender'      => $express->getSend(),
            'templateUrl' => $express->getTemplateUrl()
        ];
        
        $this->data = array_merge($this->data, $data);
    }
        
    public function getpackageInfo($assignId, $goods)
    {
        $items = [];
        foreach ($goods  as $item ){
            $items[] = ['counte'=> $item->goods_number, 'name'=>$item->goods_name];
        }
        return [
            'id'=>$assignId,
            "items"=>$items,
            "volume"=>"", //体积　非必填
            "weight"=>"", //重量　非必填
        ];
    }
        
    public function getContent()
    {
        return $this->data;
    }
    
    final public function  getApi()
    {
        return 'TMS_WAYBILL_UPDATE';
    }
}