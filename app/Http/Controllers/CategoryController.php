<?php

namespace App\Http\Controllers;

use App\models\Category;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $repository = null;
    public function  __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
    }
    
    public function index()
    {
        $service = app('App\Services\Category\CategoryService');
        $result = $service->get();
        return [
            'items'=>$result,
        ];
       // return $result;
    }

    public function getLevels(Category $category,$pid){
           $data=$category->where('level','=',$pid)->get();
            return $data;
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
        $data = $request->all();
        // DD($data);
        $re = $this->repository->create($data);
        if ($re) {
            return $this->success($re);
        } else {
            return $this->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
        $re = $this->repository->delete($id);
        if ($re) {
            return $this->success(1);;
        } else {
            return $this->error();
        }
    }
}
