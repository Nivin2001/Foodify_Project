<?php
namespace App\Http\Controllers\API\Favorite;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteRequest;
use App\Http\Resources\FavoriteResource;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected FavoriteService $service;

    public function __construct(FavoriteService $service) {
        $this->service = $service;
    }

    public function index(Request $request) {
        $favorites = $this->service->getUserFavorites($request->user()->id);
        return FavoriteResource::collection($favorites);
    }

    public function store(FavoriteRequest $request) {
        $favorite = $this->service->addToFavorites($request->user()->id, $request->dish_id);
        return response()->json(['message' => 'Added to favorites']);
    }

   public function destroy($dishId)
{
    $this->service->removeFromFavorites(auth()->id(), $dishId);
    return response()->json(['message' => 'Removed from favorites']);
}

}
?>
