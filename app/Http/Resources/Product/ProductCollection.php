<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;

class ProductCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return[
        'name'=>$this->name,
        'price'=>$this->price,
        'rating'=>$this->reviews->count()>0?round($this->reviews->sum('star')/$this->reviews->count(),2):'No rating yet',
        'stock'=>$this->stock==0? 'out of stock':$this->stock,
        'totalPrice'=>round((1-($this->discount/100))*$this->price,2),
        'href'=>[
            'link'=>route('product.show',$this->id)
        ]
    ];
    }
}
