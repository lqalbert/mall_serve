<?php

namespace App\Listeners;

use App\Events\AfterCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Alg\Sn;

class AfterCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AfterCreated  $event
     * @return void
     */
    public function handle(AfterCreated $event)
    {
        $afterSale = $event->getAfterSale();
        
       
        if (empty($afterSale->entrepot_id)) {
            return false;
        }
        $afterSale->return_sn= Sn::getRXSn($afterSale->entrepot->eng_name, $afterSale->id);
        $afterSale->save();
    }
}
