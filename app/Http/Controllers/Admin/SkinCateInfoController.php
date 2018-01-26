<?php

namespace App\Http\Controllers\Admin;

use App\models\SkinCateInfo;
use Illuminate\Http\Request;

class SkinCateInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ['items'=>SkinCateInfo::all()];
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
       return SkinCateInfo::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\SkinCateInfo  $skinCateInfo
     * @return \Illuminate\Http\Response
     */
    public function show(SkinCateInfo $skinCateInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\SkinCateInfo  $skinCateInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(SkinCateInfo $skinCateInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\SkinCateInfo  $skinCateInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SkinCateInfo $skinCateInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\SkinCateInfo  $skinCateInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(SkinCateInfo $skinCateInfo)
    {
        //
    }
}