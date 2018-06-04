<?php
namespace App\Services\WayBill\MsgType;

/**
 * 生成如下连接结构的数据
 * http://pac.i56.taobao.com/apiinfo/showDetail.htm?spm=0.0.0.0.9fnYWG&apiId=TMS_WAYBILL_UPDATE&type=merchant_electronic_sheet
 * @author hyf
 *
 */
class TmsWayBillUpdate
{
    private $data = [
        'coCode'=>'',
        'waybillCode'=>'',
        'packageInfo'=>null,
        'recipient'=>null,
        'sender'=>null,
        'templateUrl'=>""
    ];
}