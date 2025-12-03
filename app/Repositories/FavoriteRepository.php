<?php
namespace App\Repositories;

use App\Models\Favorite;

class FavoriteRepository
{
    public function getByUser($userId) {
        return Favorite::where('user_id', $userId)->with('dish')->get();
    }

    public function add($userId, $dishId) {
        return Favorite::updateOrCreate(['user_id' => $userId, 'dish_id' => $dishId]);
    }

    public function remove($userId, $dishId) {
        return Favorite::where('user_id', $userId)->where('dish_id', $dishId)->delete();
    }
}

?>
