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
        
        $this->request->setDataType($this->dataType);
    }
    
    public function getANew(OrderBasic $order)
    {
        //连接LINK PAC
        
        return '';
    }
    
    public function send($obj)
    {
        return  $this->response->setBack($this->request->setParam($obj)->send()) ;
    }
    
    
}