<?php
namespace App\Events;
use Illuminate\Support\Facades\Log;

/**
 * 生成Listerner 判断是否有 单号 
 * 如果 有  就不做什么
 * 如果没有 就生成一个
 * @author hyf
 *
 */

class ProduceEntryCreating
{
<<<<<<< HEAD

    private $produceEntry = null;
    public function __construct(\App\Models\ProduceEntry $produce)
    {
        $this->produceEntry = $produce;
 
    }
    
    public function getProduceEntry()
    {
        return $this->produceEntry;
    }

=======
//    public function __construct(App\Models\ProduceEntry $produce)
//    {
//
//
//    }
>>>>>>> 19cd9d92334d8d1ec6ca6ae677042386a4d37077
}