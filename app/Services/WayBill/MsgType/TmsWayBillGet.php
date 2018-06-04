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
        'coCode'=>'',
        'sender'=>null,
        'tradeOrderInfoDtos'=>null
    ];
}