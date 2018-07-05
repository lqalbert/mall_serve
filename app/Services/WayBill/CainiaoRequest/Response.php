<?php
namespace App\Services\WayBill\CainiaoRequest;

use Illuminate\Support\Facades\Storage;

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
        **/
       
       Storage::disk('local')->put('waybill.txt', $str);
       
       $result = json_decode($str, true);
       
       if ($result != false) {
           $returnMsg = $this->setReturnMsg($result);
       } else {
           $xml = simplexml_load_string($str);
           if ($xml === false) {
               return [
                   'status'=>0,
                   'msg'=>'返回的格式不认识',
                   'data'=>['info'=>$str]
               ];
           }
//            $str = ;
           Storage::disk('local')->put('xmltojson.txt', json_encode($xml));
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