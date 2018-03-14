<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProduceEntry;
use App\Models\ProduceEntryProduct;
use Illuminate\Support\Facades\DB;

class ProduceEntryController extends Controller
{

    public function store(Request $request)
    {
        
        DB::beginTransaction();
        try {
            $model = ProduceEntry::create($request->except('childrenData'));
            $products = $request->input('childrenData', []);
            $productsModels = [];
            foreach ($products as $product) {
                $productsModels[] = new ProduceEntryProduct($product);
            }
            if (!empty($productsModels)) {
                $model->products()->saveMany($productsModels);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return $this->error([]);
        }

        return $this->success([]);
    }
    
}
