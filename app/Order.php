<?php

namespace App;

use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

        protected $fillable = [
            'product_id', 'user_id', 'quantity', 'address' 
        ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function product()
        {
            return $this->belongsTo(Product::class);
        }

}
