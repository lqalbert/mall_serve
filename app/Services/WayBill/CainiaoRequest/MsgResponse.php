<?php
namespace App\Services\WayBill\CainiaoRequest;


abstract  class MsgResponse
{
    protected $status= 0;
    protected $data = "";
    protected $msg = "操作成功";
    
    protected $ResonseData = "";
    protected $type = "json";
    
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
    
    public function setParam($data, $type)
    {
        $this->ResonseData = $data;
        $this->type = $type;
    }
    
    /**
     * 处理数据
     * @return mixed
     */
    public function deal()
    {
        if ($this->type == 'xml') {
            $this->xmlSetAll($this->ResonseData);
        } else {
            $this->jsonSetAll($this->ResonseData);
        }
    }
    
    public function xmlSetStatus($xml)
    {
//         logger("[xml]", [get_class($xml)]);
        $successs = (string)$xml->success;
        $this->status= $successs == "false" ? 0 : 1;
    }
    
    public function jsonSetStatus($arr)
    {
        $successs = $arr['success'];
        $this->status= $successs == false ? 0 : 1;
    }
    
    public function setReturnMsg()
    {
        $returnMsg = [  'status'=>'',  'msg'=>'',   'data'=>[]  ];
        $returnMsg['status'] = $this->status;
        $returnMsg['msg'] = $this->msg;
        $returnMsg['data'] = $this->data;
       
        return $returnMsg;
    }
    
    public function xmlSetAll($xml)
    {
        $this->xmlSetStatus($xml);
        if ($this->isSuccess()) {  //成功需要设置返回数据 失败不需要
            $this->xmlSetData($xml);
        } else {
            $this->xmlSetMsg($xml);
        }
    }
    
    public function xmlSetMsg($xml)
    { //<errorMsg>
        $this->msg= (string)$xml->errorMsg;
        logger('[errorMsg]', [$this->msg]);
    }
    
    public function jsonSetAll($arr)
    {
        $this->jsonSetStatus($arr);
        if ($this->isSuccess()) { //成功需要设置返回数据 失败不需要
            $this->jsonSetData($arr);
        } else {
            $this->jsonSetMsg($arr);
        }
    }
    
    public function jsonSetMsg($arr)
    {
        $this->msg= $arr['errorMsg'];
    }
    
    
    
}
