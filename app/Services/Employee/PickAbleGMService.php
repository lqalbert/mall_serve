<?php
namespace App\Services\Employee;

use Illuminate\Http\Request;
use App\Models\RoleUser;
use App\Models\Role;

class PickAbleGMService
{

    private $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get()
    {
        // TODO 6 需要改成 $role->id => test
        $request = $this->request;
        $role = Role::where('name','group-member')->first();
        
        $re = RoleUser::select('*')->where('role_id', $role->id)
            ->with([
            'user' => function ($query) use ($request) {
                $query->select('id', 'realname', 'group_name');
                if ($request->has('unassign')) {
                    $query->where('group_id', 0)
                        ->orWhereNull('group_id');
                }
            }
        ])
            ->get();
        $result = array_pluck($re, 'user');
        return [
            'items' => $result,
            'total' => count($result)
        ];
        // return $re;
    }
}
