<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //
    use HasFactory;

    protected $fillable = ['user_id', 'dish_id', 'quantity'];

    public function dish() {
        return $this->belongsTo(Dish::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
