<?php

namespace App\Listeners;

use App\Models\Assign;
use App\Alg\Sn;
use App\Events\AssignCreating;
use App\Events\AssignCreated;

class AssignCreatedListener
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
     * @param  AssignCreating  $event
     * @return void
     */
    public function handle(AssignCreated $event)
    {
        $assign = $event->getAssign();
        if (empty($assign->entrepot_id)) {
            return false;
        }
        if (empty($assign->assign_sn)){
            $assign->assign_sn = Sn::getAssignSn($assign->entrepot->eng_name, $assign->id);
        }
        $assign->save();
        return true;
    }
}
