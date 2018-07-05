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
class TmsWayBillGet
{
    
    private $data = [
        'cpCode'=>''
    ];
    
    public function setParam($param)
    {
//         $this->data = array_merge($this->data, $param);
    }
    
    public function setDataType($dataType)
    {
        
    }
    
    public function getContent($dataType)
    {
//         logger('xml', [$dataType]);
//         if ($dataType == 'xml') {
//             return $this->toXml($this->data);
//         } else {
//             return json_encode($this->data);
//         }
        $str = <<<ET
        <request>
    <cpCode>EMS</cpCode>
    <sender>
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
    </sender>
    <tradeOrderInfoDtos>
            <tradeOrderInfoDto>
                <objectId>1</objectId>
                <orderInfo>
                    <orderChannelsType>OTHERS</orderChannelsType>
                    <tradeOrderList>
                            <tradeOrder>ssas</tradeOrder>
                    </tradeOrderList>
                </orderInfo>
                <packageInfo>
                    <id>1</id>
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
                <templateUrl>http://cloudprint.daily.taobao.net/template/standard/137411/1</templateUrl>
                <userId>12</userId>
            </tradeOrderInfoDto>
    </tradeOrderInfoDtos>
</request>
ET;
//         return  str_replace(["\t","\n","\r","\0","\x0B"," "], "", trim($str));
        return  trim($str);
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
        return 'TMS_WAYBILL_GET';
    }
}