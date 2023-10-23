<?php

namespace App\Http\Controllers\API\User;


use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\User\Favorites;
use App\Services\CachingService;
use App\Services\JWTService;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct()
    {
        // 
    }

    

    /**
     * Get user favorite movies.
     * 
     * @param Request $request
     */
    public function favorites(Request $request)
    {
        $cached = CachingService::getCachedFavorites();
        if($cached) return response()->json($cached, 200);

        $user = JWTService::getUserFromToken($request);
        return response()->json($user->favorites(), 200);
    }



    /**
     * Add movie to favorites.
     * 
     * @param Request $request
     */
    public function add(Request $request)
    {
        if(!isset($request->movie_id)) return response()->json('Bad request', 400);

        $movie = Movie::find($request->movie_id);
        if(!$movie) return response()->json('Not found', 404);

        $user = JWTService::getUserFromToken($request);

        $exists = Favorites::where('movie_id', $request->movie_id)->where('user_id', $user->id)->first();
        if($exists) return response()->json('This movie is already in your favorites.', 400);

        Favorites::create([
            'movie_id'  => $request->movie_id,
            'user_id'   => $user->id
        ]);

        return response()->json($user->favorites(), 200);
    }



    /**
     * Remove movie from favorites.
     * 
     * @param Request $request
     */
    public function remove(Request $request)
    {
        if(!isset($request->movie_id)) return response()->json('Bad request', 400);

        $user = JWTService::getUserFromToken($request);

        $favorite = Favorites::where('movie_id', $request->movie_id)->where('user_id', $user->id)->first();
        if(!$favorite) return response()->json('Not found', 404);

        $favorite->delete();
        
        return response()->json($user->favorites(), 200);
    }
}
