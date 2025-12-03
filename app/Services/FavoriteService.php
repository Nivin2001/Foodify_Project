<?php
namespace App\Services;

use App\Repositories\FavoriteRepository;

class FavoriteService
{
    protected FavoriteRepository $repo;

    public function __construct(FavoriteRepository $repo) {
        $this->repo = $repo;
    }

    public function getUserFavorites($userId) {
        return $this->repo->getByUser($userId);
    }

    public function addToFavorites($userId, $dishId) {
        return $this->repo->add($userId, $dishId);
    }

    public function removeFromFavorites($userId, $dishId) {
        return $this->repo->remove($userId, $dishId);
    }
}
?>
