<?php
namespace App\Services\WayBill\MsgType;

/**
 * 生成如下连接结构的数据
 * http://pac.i56.taobao.com/apiinfo/showDetail.htm?spm=0.0.0.0.WcSVHI&apiId=TMS_WAYBILL_GET&type=merchant_electronic_sheet
 * @author hyf
 *
 */
class TmsWayBillGet 
{
    private $data = [
        'cpCode'=>'',
        'sender'=>null,
        'tradeOrderInfoDtos'=>null
    ];
    //来处快递公司
    /* 'sender'=>[
        'address'=>[
            'province'=>"",
            'city'    =>"",
            'district'=>"",
            'town'    =>"",
            'detail'  =>""
        ],
        "phone"=>"",
        "mobile"=>"",
        "name"=>""
    ] */
    
    //这个是数组　最多可以有10个
    /* 'tradeOrderInfoDtos'=>[
        [
            "logisticsServices" => "",//可以不填
            "objectId"=>"" //必填 string 32位
            "orderInfo"=>[
                'orderChannelsType'=>'OTHERS' //订单渠道平台编码
                'tradeOrderList' => [
                    '订单号1'
                ]    
            ],
            "packageInfo"=>[
                "id"=>"",
                "items"=>[
                    ['count'=>1,'name'=>'洗脸的'],
                    ['count'=>2,'name'=>'洗脸的3'],
                ],
                "volume"=>"", //体积　非必填
                "weight"=>"", //重量　非必填
            ],
            'recipient'=>[
                'address'=>[
                    'province'=>"",
                    'city'    =>"",
                    'district'=>"",
                    'town'    =>"",
                    'detail'  =>""
                ],
                "phone"=>"",
                "mobile"=>"",
                "name"=>""
            ],
            'templateUrl'=>'',//模板URL
            'userId'=>'', //使用者ID
        ]
    ] */
    
    public function setParam($assign, $express, $order, $userId)
    {
        $data = [
            'cpCode'=>$express->eng,
            'sender' => $express->getSend(),
            'tradeOrderInfoDtos'=> $this->getOrderInfo($assign ,$order, $express->getTemplateUrl(), $userId)
        ];
        
        $this->data = array_merge($this->data, $data);
        
    }
    //目前只生成一个
    public function getOrderInfo($assign, $order, $templateUrl, $userId)
    {
        
        return [
            "logisticsServices" => "",//可以不填
            "objectId"=>$order->id,//必填 string 32位
            "orderInfo"=>[
                'orderChannelsType'=>'OTHERS', //订单渠道平台编码
                'tradeOrderList' => [
                    $order->order_sn
                ]
            ],
            "packageInfo"=> $assign->getPackageInfo(),
            'recipient'=> $order->getRecipient(),
            'templateUrl'=>$templateUrl,//模板URL
            'userId'=>$userId, //使用者ID
        ];
    }
    
    
    public function getContent()
    {
        return $this->data;
    }
    
    final public function  getApi()
    {
        return 'TMS_WAYBILL_GET';
    }
}