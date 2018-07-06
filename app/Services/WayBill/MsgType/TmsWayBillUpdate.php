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
        return '';
    }
    
    
    
    public function getToCode()
    {
        return '';//$this->data['cpCode'];
    }
    
    final public function  getApi()
    {
        return 'TMS_WAYBILL_UPDATE';
    }
    
    
}