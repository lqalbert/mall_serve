<?php

namespace App\Listeners;

use App\Events\InventoryChecked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Alg\Sn;

class InventoryCheckedListener
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
     * @param  InventoryChecked  $event
     * @return void
     */
    public function handle(InventoryChecked $event)
    {
        $model = $event->getCheckRecord();
        if (empty($model->entrepot_id)) {
            return false;
        }
        if (empty($model->check_sn)){
            $model->check_sn= Sn::getCheckSn($model->entrepot->eng_name, $model->id);
        }
        $model->save();
    }
}
