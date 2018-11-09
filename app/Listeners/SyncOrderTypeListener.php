<?php

namespace App\Listeners;

use App\Events\SyncDiscount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use App\Models\OrderType;

class SyncOrderTypeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->orderType = OrderType::where('name',OrderType::INNER_NAME)->first();
    }

    /**
     * Handle the event.
     *
     * @param  SyncDiscount  $event
     * @return void
     */
    public function handle(SyncDiscount $event)
    {
        $model = $event->getModel();
        $n = $model->n ;
        if ($n  != $this->orderType->discount ) {
            $this->orderType->discount = $n;
            if(!$this->orderType->save()) {
                throw new \Exception('同步折扣失败');
            }
        }
    }
}
