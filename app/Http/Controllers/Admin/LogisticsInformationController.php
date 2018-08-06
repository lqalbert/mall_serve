<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogisticsInformation;
use App\Models\ExpressCompany;
use Illuminate\Http\Request;
use App\Services\LogisticsInformation\LogisticsInformationService;
class LogisticsInformationController extends Controller
{
    public $model=null;
    private $service = null;
    public function __construct(LogisticsInformation $logisticsInformation,LogisticsInformationService $logisticsInformationService)
    {
        $this->model = $logisticsInformation;
        $this->service = $logisticsInformationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       return  $this->service->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogisticsInformation  $logisticsInformation
     * @return \Illuminate\Http\Response
     */
    public function show(LogisticsInformation $logisticsInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogisticsInformation  $logisticsInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(LogisticsInformation $logisticsInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogisticsInformation  $logisticsInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogisticsInformation $logisticsInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogisticsInformation  $logisticsInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogisticsInformation $logisticsInformation)
    {
        //
    }
}
