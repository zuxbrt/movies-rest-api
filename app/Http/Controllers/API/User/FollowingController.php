<?php

namespace App\Http\Controllers\API\User;


use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\User\Following;
use App\Services\JWTService;
use Illuminate\Http\Request;

class FollowingController extends Controller
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
    public function following(Request $request)
    {
        $user = JWTService::getUserFromToken($request);
        return response()->json($user->following(), 200);
    }



    /**
     * Follow a movie.
     * 
     * @param Request $request
     */
    public function follow(Request $request)
    {
        if(!isset($request->movie_id)) return response()->json('Bad request', 400);

        $movie = Movie::find($request->movie_id);
        if(!$movie) return response()->json('Not found', 404);

        $user = JWTService::getUserFromToken($request);

        $exists = Following::where('movie_id', $request->movie_id)->where('user_id', $user->id)->first();
        if($exists) return response()->json('You are already following this movie.', 400);

        Following::create([
            'movie_id'  => $request->movie_id,
            'user_id'   => $user->id
        ]);

        return response()->json($user->following(), 200);
    }



    /**
     * Stop following a movie.
     * 
     * @param Request $request
     */
    public function unfollow(Request $request)
    {
        if(!isset($request->movie_id)) return response()->json('Bad request', 400);

        $user = JWTService::getUserFromToken($request);

        $following = Following::where('movie_id', $request->movie_id)->where('user_id', $user->id)->first();
        if(!$following) return response()->json('Not found', 404);

        $following->delete();
        
        return response()->json($user->following(), 200);
    }
}
