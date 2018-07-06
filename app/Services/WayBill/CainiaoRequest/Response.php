<?php
namespace App\Services\WayBill\CainiaoRequest;

use Illuminate\Support\Facades\Storage;

class Response 
{
    
    private $msg = null;
    private $dataType = "json";
    
    public function __construct() 
    {
      
            
    }
    
    
    public function setBackClass($class)
    {
        logger("[response]", [$class]);
        switch ($class) {
            case 'TMS_WAYBILL_GET':
                $this->msg = new TmsWayBillGetResponse();
                break;
            case 'TMS_WAYBILL_SUBSCRIPTION_QUERY':
                $this->msg = new TmsWayBillSubscriptionQueryResponse();
                break;
             default:
                 throw new \Exception('请求接口没有设置返回处理类');
        }
        
        logger("[response]", [get_class($this->msg)]);
    }
    
    public function setDataType($str)
    {
        $this->dataType = $str;
    }
    
    /**
     * 把返回的消息重新格式化一下
     * 
     * ['status'=>1, 'msg'=>'操作成功', 'data'=>null ];
     * @param unknown $str
     */
   public function setBack($str)
   {
       /*
        * １判断一下返回的数组格式 json 还是 xml
        *   
        **/
       Storage::disk('local')->put('waybill.xml', $str);
       
       if ($this->dataType == 'json') {
           $result = json_decode($str, true);
           $this->msg->setParam($result, $this->dataType);
       } else {
           $xml = simplexml_load_string($str);
           if ($xml === false) {
               return [
                   'status'=>0,
                   'msg'=>'返回的格式不认识',
                   'data'=>['info'=>$str]
               ];
           }
           $this->msg->setParam($xml, $this->dataType);
       }

        $this->msg->deal();
        return $this->msg->setReturnMsg();
   }
}
