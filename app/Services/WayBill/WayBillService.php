<?php
namespace App\Services\WayBill;

use App\models\OrderBasic;
use App\Services\WayBill\CainiaoRequest\Request;
use App\Services\WayBill\CainiaoRequest\Response;

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
    
    public function getANew(OrderBasic $order)
    {
        //连接LINK PAC
        
        return '';
    }
    
    public function send($obj)
    {
        $this->response->setBackClass($obj->getApi());
        return  $this->response->setBack($this->request->setParam($obj)->send());
    }
    
    
}