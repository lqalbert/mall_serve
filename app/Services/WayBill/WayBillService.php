<?php
namespace App\Services\WayBill;

use App\models\OrderBasic;
use App\Services\WayBill\CainiaoRequest\Request;
use App\Services\WayBill\CainiaoRequest\Response;
use App\Services\WayBill\MsgType\TmsWayBillUpdate;

class WayBillService 
{
    
    public $dataType = 'xml';//json
    
    public function __construct(Request $cainiaorequest, Response $cainiaoresponse) {
        $this->request = $cainiaorequest;
        $this->response = $cainiaoresponse;
        
        $this->dataType = env('APP_ENV') != 'production' ? 'xml' :'json';
        
        $this->request->setDataType($this->dataType);
        $this->response->setDataType($this->dataType);
    }
    
    public function updateWayBill($assign, $express, $order)
    {
        $cmd = new TmsWayBillUpdate();
        $cmd->setParam($assign, $express, $order);
        
        return $this->send($cmd);
    }
    
    
    public function send($obj)
    {
        $this->response->setBackClass($obj->getApi());
        return  $this->response->setBack($this->request->setParam($obj)->send());
    }
    
    
}
