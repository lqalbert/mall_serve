<?php
namespace App\Events;
/**
 * 判断是否有 单号 
 * 如果 有  就不做什么
 * 如果没有 就生成一个
 * @author hyf
 *
 */

class ProduceEntryCreating
{
    public function __construct(App\Models\ProduceEntry $produce)
    {
        
        
    }
}