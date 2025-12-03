<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //
    protected $fillable = ['user_id', 'dish_id'];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}

