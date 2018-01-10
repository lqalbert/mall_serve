<?php

namespace App\Http\Controllers;

use App\Models\Orderlist;
use Illuminate\Http\Request;
use App\Repositories\OrderlistRepository;
use App\Services\Orderlist\OrderlistService;
use App\Repositories\Criteria\Orderlist\Time;

class OrderlistController extends Controller
{
    //
    private $repository = null;
    public function  __construct(OrderlistRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business = $request->query('business', 'default');
        $result = [];
        switch ($business){
            case 'Orderlist':
                $service = app('App\Services\Orderlist\OrderlistService');

                $result = $service->get();
                break;
            case 'select':
                $service = app('App\Services\Orderlist\OrderlistService');

                $result = $service->get();
                break;
            case 'pre_pay':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get_order_status('pre_pay');
                break;
            case 'pre_affirm':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get_order_status('pre_affirm');
                break;
            case 'pre_deliver':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get_deliver_status('pre_deliver');
                break;
            case 'delivered':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get_deliver_status('delivered');
                break;
            case 'received':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get_deliver_status('received');
                break;
            case 'done':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get_order_status('done');
                break;
            case 'closed':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get_order_status('closed');
                break;
            case 'refund':
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get_order_status('refund');
                break;
            default:
                $service = app('App\Services\Orderlist\OrderlistService');
                $result = $service->get();
        }
        return $result;
    }
}
