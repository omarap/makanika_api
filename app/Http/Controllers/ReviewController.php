<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\ReviewResource;
use App\Product;
use Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Review $review)
    {
        //$reviews = Review::where('product_id', $product)->get();
        //return response()->json($reviews, 200);
        return Review::all();
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
    public function store(Request $request, Product $product)
    {
        $rules=[
            'review'=>'required|integer|between:0,5',
            'star'=>'required',
            'user_id'=>'required',
            'product_id'=>'required',
        ];

        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->Json($validator->errors(),401);
        }

        $review = Review::create([
            'review' => $request->review,
            'star' => $request->star,
            'user_id' => $request->user_id,
            'product_id'=>$request->product_id
            
        ]);

        return response()->json([
            'status' => (bool) $review,
            'data'   => $review,
            'message' => $review ? 'Review Created!' : 'Error Creating Review'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        $review->update($request->all());
        return response([
            'data'=>$review,
            'message' => $review ? 'Review Updated!' : 'Error Updating Review'
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response(null,401);
    }
}
