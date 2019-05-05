<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Product\ProductCollection;
use Illuminate\Http\Resources\Product\ProductResource;
use Validator;
use App\Exceptions\ProductNotBelongsToUser;
use Auth;
use ProductUserCheck;


class ProductController extends Controller
{

    //checks if a product belongs to a particular user with id
    public function ProductUserCheck($product){
        if(Auth::id()!==$product->user_id){
            throw new ProductNotBelongsToUser;
        }
    }
//authorize creating and updating product except show and index
    public function _construct(){
        $this->middleware('auth:api')->exept('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return response()->json(Product::all(),200);
        return Product::paginate(20);

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
        //checks user_id
      // $this->ProductUserCheck($product);

        $rules=[
            'name'=>'required|unique:products|max:255',
            'description'=>'required',
            'units'=>'required|max:10',
            'price'=>'required|max:255',
            'stock'=>'required|max:255',
            'discount'=>'required|max:50',
            'user_id'=>'required',
            'category_id'=>'required'
        ];

        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->Json($validator->errors(),401);
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'units' => $request->units,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
        ]);

        return response()->json([
            'status' => (bool) $product,
            'data'   => $product,
            'message' => $product ? 'Product Created!' : 'Error Creating Product'
        ],201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($product,200);
    }

    public function uploadFile(Request $request)
        {
            if($request->hasFile('image')){
                $name = time()."_".$request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('images'), $name);
            }
            return response()->json(asset("images/$name"),201);
        }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //checks user_id
        //$this->ProductUserCheck($product);

        $status = $product->update(
            $request->only([ 'name', 'description', 'units', 'price', 'stock','discount','image','user_id','category_id'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Updated!' : 'Error Updating Product'
        ]);


    }

    public function updateUnits(Request $request, Product $product)
    {
        $product->units = $product->units + $request->get('units');
        $status = $product->save();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Units Added!' : 'Error Adding Product Units'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $status = $product->delete();

            return response()->json([
                'status' => $status,
                'message' => $status ? 'Product Deleted!' : 'Error Deleting Product'
            ]);


    }
}
