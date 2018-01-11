<?php
namespace App\Listeners;

use App\Events\AddEmployee;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class AttachEmployeeRoleListener
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
     * @param AddEmployee $event            
     * @return void
     */
    public function handle(AddEmployee $event)
    {
        $user = $event->getUser();
        $roleId = $user->role_id;
        
        if (empty($roleId)) {
            return;
        }
        
        $role = Role::find($roleId);
        $relative = Role::getRelative($role->name);
        if (!$relative) {
            return ;
        }
        
//         Log::info('[event] attach employee relative Role', $relative);
        
        $hideRoles = [$role];
        foreach ($relative as $value){
            $hideRoles[] = Role::withoutGlobalScope('hide')->where('name', $value)->first();
        }
        
        Log::info('[event] attach employee hideRoles Role', $hideRoles);
        //以防万一
        if ($hideRoles) {
           
            $user->attachRoles($hideRoles);
        }
    }
}
