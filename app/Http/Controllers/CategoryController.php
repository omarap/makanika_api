<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
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
        $rules=[
            'category_name'=>'required|unique:categories',
            'description'=>'required',
            'url'=>'required',
            'parent_id'=>'required',
        ];

        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->Json($validator->errors(),401);
        }
            $category=new Category;
            $category->category_name=$request->category_name;
            $category->description=$request->description;
            $category->url=$request->url;
            $category->parent_id=$request->parent_id;
            $category->save();
            $levels=Category::where(['parent_id'=>0])->get();
            return $response->Json($category,201)->with(compact('levels'));
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if($request->isMethod('POST')){
            $data=$request->all();
            Category::where(['id'=>$id])->update
            ([
                'category_name'=>$data['category_name'],
                'description'=>$data['description'],
                'url'=>$data['url']
            ]);
            return $response->Json(['category updated successfully',
            'data'=> $category
            ],200);
        }
        $categoryDetails=Category::where(['id'=>$id])->first();
        $levels=Category::where(['parent_id'=>0])->get();
        return $response->json($category)->with(compact('categoryDetails','levels'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if(!empty($id)){
            Category::where(['id'->$id])->delete();
            return redirect()->back()->with('flash message success','category deleted successfully!');
        }
    }
}
