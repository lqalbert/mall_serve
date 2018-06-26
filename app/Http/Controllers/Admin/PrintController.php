<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Assign;

class PrintController extends Controller
{
    //快递单打印
    public function index($id)
    {
        return view('print/index');
    }
    
    public function printAssign($id)
    {
        $assign = Assign::findOrFail($id);
        return view('print/index', ['model'=>$assign]);
    }
}
