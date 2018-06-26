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
    
    public function setParam($assign, $express, $userId)
    {
        $data = [
            'cpCode'=>$express->eng,
            'sender' => $express->getSend(),
            'tradeOrderInfoDtos'=> $this->getOrderInfo($assign, $express->getTemplateUrl(), $userId)
        ];
        
        $this->data = array_merge($this->data, $data);
        
    }
    
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
                        $item->order->order_sn
                    ]
                ],
                "packageInfo"=> $item->getPackageInfo(),
                'recipient'=> $item->order->getRecipient(),
                'templateUrl'=>$templateUrl,//模板URL
                'userId'=>$userId, //使用者ID
            ];
        }
        
        return $result;
    }
    
    
    public function getContent()
    {
        return $this->data;
    }
    
    public function getToCode()
    {
        return  '';//$this->data['cpCode'];
    }
    
    final public function  getApi()
    {
        return 'TMS_WAYBILL_GET';
    }
}