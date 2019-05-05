<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=[
      'category_name','description','url','parent_id'
    ];

    //product has many products
    public function products(){
        return $this->hasMany(Product::class);
    }
}
