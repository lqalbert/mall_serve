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
                'recipient'=> $item->address->getRecipient(),
                'templateUrl'=>$templateUrl,//模板URL
                'userId'=>$userId, //使用者ID
            ];
        }
        
        return $result;
    }
    
    
    public function getContent($dataType)
    {
        if ($dataType == 'xml') {
            return $this->toXml($this->data);
        } else {
            return json_encode($this->data);
        }
        
    }
    
    public function getToCode()
    {
        return  '';// $this->data['cpCode'];
    }
    
    final public function  getApi()
    {
        return 'TMS_WAYBILL_GET';
    }
    
    public function toXml($data)
    {
        $xml = simplexml_load_string('<request></request>');

        $xml->addChild('cpCode', $data['cpCode']);
        
        $this->setSender($xml, $data['sender']);
        $this->addTrade($xml, $data['tradeOrderInfoDtos']);
        return html_entity_decode($xml->saveXML(), ENT_NOQUOTES, 'UTF-8');

    }
    
    public function setSender($xml, $data)
    {
        
        $sender = $xml->addChild('sender');
        $this->setAddress($sender, $data['address']);
        $sender->addchild('phone', $data['phone']);
        $sender->addchild('mobile', $data['mobile']);
        $sender->addchild('name', $data['name']);
        $sender = null;
    }
    
    public function setAddress($xml, $data)
    {   
        $address = $xml->addChild('address');
        foreach ($data as $key=>$item) {
            $address->addChild($key, $item);
        }
        $address = null;
    }
    
    public function addTrade($xml, $data)
    {
        $trades = $xml->addChild('tradeOrderInfoDtos');
        foreach ($data as $items) {
            $tradDto = $trades->addChild('tradeOrderInfoDto');
            if (isset($items['logisticsServices'])) {
                $tradDto->addChild('logisticsServices', $items['logisticsServices']);
            }
            
            $tradDto->addChild('objectId', $items['objectId']);
            $this->setOrderInfo($tradDto, $items['orderInfo']);
            $this->setPackageInfo($tradDto, $items['packageInfo']);
            $this->setRecipient($tradDto, $items['recipient']);
            $tradDto->addChild('templateUrl', $items['templateUrl']);
            $tradDto->addChild('userId', $items['userId']);
            $tradDto = null;
        }
    }
    
    public function setOrderInfo($xml,$data)
    {
        $orderInfoXml = $xml->addChild('orderInfo');
        $orderInfoXml->addChild('orderChannelsType', $data['orderChannelsType']);
        $tradeOrderListXml = $orderInfoXml->addChild('tradeOrderList');
        $tradeOrderListXml->addChild('tradeOrder', $data['tradeOrderList'][0]);
        
    }
    
    public function setPackageInfo($xml, $data) 
    {
        $packageInfoxml = $xml->addChild('packageInfo');
        $packageInfoxml->addChild('id', $data['id']);
        $this->setPackageInfoItems($packageInfoxml, $data['items']);
        if (isset($data['volume'])) {
            $packageInfoxml->addChild('volume', $data['volume']);
        }
        
        if (isset($data['weight'])) {
            $packageInfoxml->addChild('weight', $data['weight']);
        }   
    }
    
    public function setPackageInfoItems($xml, $data)
    {
        $items = $xml->addChild('items');
        foreach ($data as $product) {
            $item  = $items->addChild('item');
            $item->addChild('count', $product['count']);
            $item->addChild('name',  $product['name']);
        }
    }
    
    public function setRecipient($xml, $data)
    {
        $recipient= $xml->addChild('recipient');
        $this->setAddress($recipient, $data['address']);
        $recipient->addchild('phone', $data['phone']);
        $recipient->addchild('mobile', $data['mobile']);
        $recipient->addchild('name', $data['name']);
    }
}
