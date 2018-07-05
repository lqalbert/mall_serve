<?php
namespace App\Services\WayBill\CainiaoRequest;

abstract  class MsgResponse
{
    protected $status= 0;
    protected $data = "";
    protected $msg = "操作成功";
    
    
    public function isSuccess()
    {
        return $this->status == 1;
    }
    
    public function getStatus()
    {
        return $this->status;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function getMsg()
    {
        return $this->msg;
    }
    
    public function xmlSetStatus($xml)
    {
        logger("[xml]", [get_class($xml)]);
        $successs = (string)$xml->success;
        $this->status= $successs == "false" ? 0 : 1;
    }
    
    public function setReturnMsg()
    {
        $returnMsg = [  'status'=>'',  'msg'=>'',   'data'=>[]  ];
        $returnMsg['status'] = $this->status;
        $returnMsg['msg'] = $this->msg;
        $returnMsg['data'] = $this->data;
        
        return $returnMsg;
    }
    
    
    
}