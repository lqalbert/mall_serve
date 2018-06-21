<?php

namespace App\Listeners;

use App\Events\StockChecked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Alg\Sn;

class StockSnListener
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
     * @param  StockChecked  $event
     * @return void
     */
    public function handle(StockChecked $event)
    {
        $model = $event->getModel();
        $entrepot = $model->entrepot;
        $model->check_sn = Sn::getCheckSn($entrepot->eng_name, $model->id);
        $model->save();
    }
}
