<?php

namespace App;

use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable=[
       'review','star', 'user_id', 'product_id'
    ];

    //a review belongs to user
    public function user()
    {
      return $this->belongsTo(User::class);
    }

    //a review belongs to product
    public function product()
    {
      return $this->belongsTo(Product::class);
    }
}
