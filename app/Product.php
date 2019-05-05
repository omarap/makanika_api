<?php

namespace App;

use App\Review;
use App\Order;
use App\Category;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

        protected $fillable = [
            'name', 'description', 'units', 'price', 'stock','discount','image','user_id','category_id'
        ];

        //product has many orders
        public function orders(){
            return $this->hasMany(Order::class);
        }

        //product has many reviews
        public function reviews(){
            return $this->hasMany(Review::class);
        }
        
        //products belongs to a user
        public function user(){
            return $this->belongsTo(User::class);
        }
        //products belongs to a category
        public function category(){
            return $this->belongsTo(Category::class);
        }

}
