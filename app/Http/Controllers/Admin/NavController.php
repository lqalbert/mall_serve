<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Object_;
use Illuminate\Support\Facades\Log;
use App\Services\Nav\MenuService;

class NavController extends Controller
{
    public function __construct(MenuService $service)
    {
        $this->service = $service;
    }
	
	public function getNav()
	{
		$user  =   Auth::user();
		$roles = $user->roles;
		
		return $this->service->getMenus(array_column($roles->toArray(),'name'));
	}
}
