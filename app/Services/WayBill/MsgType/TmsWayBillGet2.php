<?php
namespace App\Services\WayBill\MsgType;

class TmsWayBillGet2 extends TmsWayBillGet
{
    /**
     * 要改的
     * {@inheritDoc}
     * @see \App\Services\WayBill\MsgType\TmsWayBillGet::setParam()
     */
    public function setParam($assign, $express, $userId)
    {
        $data = [
            'cpCode'=>$express->eng,
            'sender' => $express->getSend(),
            'tradeOrderInfoDtos'=> $this->getOrderInfo($assign, $express->getTemplateUrl(), $userId)
        ];
//         logger("[sender]", $data);
        
        $this->data = array_merge($this->data, $data);
        
    }
    
    
    /**
     * 要改的
     * {@inheritDoc}
     * @see \App\Services\WayBill\MsgType\TmsWayBillGet::getOrderInfo()
     */
    public function getOrderInfo($assign, $templateUrl, $userId)
    {
        $result = [];
        
        foreach ($assign as $item) {
            $result[] = [
                "logisticsServices" => "",//可以不填
                "objectId"=>$item->id,//必填 string 32位
                "orderInfo"=>[
                    'orderChannelsType'=>'OTHERS', //订单渠道平台编码
                    'tradeOrderList' => [
                        "{$item->id}" //这里必须是数字，否则要抱错
                    ]
                ],
                "packageInfo"=> $item->getPackageInfo(),
                'recipient'=> $item->getRecipient(),
                'templateUrl'=>$templateUrl,//模板URL
                'userId'=>$userId, //使用者ID
            ];
        }
//         logger('[get2]', $result);
        return $result;
    }
}
