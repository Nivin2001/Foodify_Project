<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    /** @use HasFactory<\Database\Factories\DishFactory> */
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'image',
        'description',
        'price',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber',
        'rating',
        'is_favorite',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
