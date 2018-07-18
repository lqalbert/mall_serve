<?php
namespace App\Services\WayBill\MsgType;

/**
 * 生成如下连接结构的数据
 * 有误　应该是更新哪些数据就传哪些数据
 * http://pac.i56.taobao.com/apiinfo/showDetail.htm?spm=0.0.0.0.9fnYWG&apiId=TMS_WAYBILL_UPDATE&type=merchant_electronic_sheet
 * @author hyf
 * 
 * 未完成
 * <request>
    <cpCode>POSTB</cpCode>
    <waybillCode>9890000160004</waybillCode>
    <objectId>x</objectId>
    <logisticsServices>json串</logisticsServices>
    <packageInfo>
        <items>
                <item>
                    <count>1</count>
                    <name>衣服</name>
                </item>
        </items>
        <volume>1</volume>
        <weight>1</weight>
    </packageInfo>
    <recipient>
        <address>
            <city>北京市</city>
            <detail>花家地社区卫生服务站</detail>
            <district>朝阳区</district>
            <province>北京</province>
            <town>望京街道</town>
        </address>
        <mobile>1326443654</mobile>
        <name>Bar</name>
        <phone>057123222</phone>
    </recipient>
    <sender>
        <mobile>1326443654</mobile>
        <name>Bar</name>
        <phone>057123222</phone>
    </sender>
    <templateUrl>http://cloudprint.cainiaoRL.com/cloudprint/template/getStandardTemplate.json?template_id=1001</templateUrl>
</request>

{
    "cpCode":"POSTB",
    "logisticsServices":"json串",
    "sender":{
        "phone":"057123222",
        "mobile":"1326443654",
        "name":"Bar"
    },
    "recipient":{
        "address":{
            "province":"北京",
            "town":"望京街道",
            "city":"北京市",
            "district":"朝阳区",
            "detail":"花家地社区卫生服务站"
        },
        "phone":"057123222",
        "mobile":"1326443654",
        "name":"Bar"
    },
    "waybillCode":"9890000160004",
    "packageInfo":{
        "volume":"1",
        "weight":"1",
        "items":[
            {
                "count":"1",
                "name":"衣服"
            }
        ]
    },
    "objectId":"x",
    "templateUrl":"http://cloudprint.cainiaoRL.com/cloudprint/template/getStandardTemplate.json?template_id=1001"
}
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
            'objectId' => $assign->id,
            'packageInfo' => $assign->getPackageInfo(),
            'recipient'   => $order->getRecipient(),
            'sender'      => $express->getSend(),
            'templateUrl' => $express->getTemplateUrl()
        ];
        
        $this->data = array_merge($this->data, $data);
    }
        
    
        
    public function getContent($dataType)
    {
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
        $xml->addChild('waybillCode', $data['waybillCode']);
        $xml->addChild('objectId', $data['objectId']);
        $xml->addChild('templateUrl', $data['templateUrl']);
        
        $this->setPackageInfo($xml, $data['packageInfo']);
        $this->setRecipient($xml, $data['recipient']);
        $this->setSender($xml, $data['sender']);
        
        
        return html_entity_decode($xml->saveXML(), ENT_NOQUOTES, 'UTF-8');
    }

    
    public function getToCode()
    {
        return '';//$this->data['cpCode'];
    }
    
    final public function  getApi()
    {
        return 'TMS_WAYBILL_UPDATE';
    }
    
    public function setPackageInfo($xml, $data)
    {
        $packageInfoxml = $xml->addChild('packageInfo');
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
    
    public function setSender($xml, $data)
    {
        $sender = $xml->addChild('sender');
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
    
}