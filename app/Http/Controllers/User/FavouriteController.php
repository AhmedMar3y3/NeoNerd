<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Resources\FavouriteResource;

class FavouriteController extends Controller
{
    use HttpResponses; // <--- include trait

    // Add to favourites
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $userId = auth()->id();

        // Prevent duplicate favourites
        $favourite = Favourite::firstOrCreate([
            'user_id'   => $userId,
            'course_id' => $request->course_id,
        ]);

        return $this->successWithDataResponse(new FavouriteResource($favourite));
    }

    // Remove from favourites
    public function destroy($courseId)
    {
        $userId = auth()->id();

        $deleted = Favourite::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->delete();

        if ($deleted) {
            return $this->successResponse('Course removed from favourites');
        }

        return $this->failureResponse('Course not found in favourites');
    }

    // List favourites
    public function index()
    {
        $favourites = Favourite::where('user_id', auth()->id())
            ->with('course')
            ->get();

        return $this->successWithDataResponse(
            FavouriteResource::collection($favourites)
        );
    }
}
