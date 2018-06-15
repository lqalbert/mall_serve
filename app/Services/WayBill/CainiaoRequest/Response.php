<?php
namespace App\Services\WayBill\CainiaoRequest;

class Response 
{

    
    public function __construct() 
    {
      
            
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
        *   */
       $result = json_decode($str, true);
       
       if ($result != false) {
           $returnMsg = $this->setReturnMsg($result);
       } else {
           /* 
            * <response>
                <success>false</success>
                <errorCode>S23</errorCode>
                <errorMsg>查询不到应用授权信息:please authorize to resources,can't find  app through fromCode =4d2e8684082d47f0bfd07ecef3adb57b traceId:0abdc1d315281814365342415e3a38</errorMsg>
            </response> 
            */
           $xml = simplexml_load_string($str);
           if ($xml === false) {
               return [
                   'status'=>0,
                   'msg'=>'返回的格式不认识',
                   'data'=>['info'=>$str]
               ];
           }
           $returnMsg = $this->setReturnMsg(json_decode(json_encode($xml), true));  
       }
       
       return $returnMsg;
   }
   
   public function setReturnMsg($result)
   {
       $returnMsg = [  'status'=>'',  'msg'=>'',   'data'=>[]  ];
       $returnMsg['status'] = $result['success'] == "false" ? 0 : 1;
       $returnMsg['msg'] = $result['success'] == "false" ? $result['errorMsg'] : '操作成功';
       $returnMsg['data'] = $result;
       
       return $returnMsg;
   }
    
}