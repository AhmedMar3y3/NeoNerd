<?php
namespace App\Http\Controllers\User;

use App\Models\Course;
use App\Models\Favourite;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\FavouriteResource;

class FavouriteController extends Controller
{
    use HttpResponses;

    public function toggleFavorite($id)
    {
        $course = Course::findOrFail($id);
        $result = auth()->user()->favourites()->toggle($course->id);
        return $this->successWithDataResponse(['is_favorite' => empty($result['detached']) ? true : false]);
    }

    public function list()
    {
        $favourites = Favourite::where('user_id', auth()->id())->with('course')->get();
        return $this->successWithDataResponse(FavouriteResource::collection($favourites));
    }
}
