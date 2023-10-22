<?php

namespace App\Http\Controllers\API;

use App\Helpers\Pagination;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MoviesController extends Controller
{
    public function __construct()
    {
        //
    }


    /**
     * Get movies or single movie depending on params sent in the request.
     * @param Request $request
     */
    public function movies(Request $request)
    {
        $pagination = new Pagination(Movie::class);
        if(isset($request->page) && isset($request->results) && isset($request->orderby) && isset($request->order)){
            $data = $pagination->paginate(
                $request->page, 
                $request->results,
                $request->orderby,
                $request->order,
                isset($request->search) ? $request->search : null
            );
            return response()->json($data, 200);
        } else if (isset($request->slug)) {
            $movie = Movie::where('slug', $request->slug)->first();
            if($movie) return response()->json($movie, 200);
            return response()->json([], 404);
        } else {
            return response()->json(Movie::all(), 200);
        }
        
    }



    /**
     * Add a movie.
     * @param Request $request
     */
    public function addMovie(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'min:5'],
        ]);

        if($validator->fails()){
            return response()->json($validator->messages()->all(), 400);
        }

        $alreadyExists = Movie::where('title', $request->title)->get();
        if(!$alreadyExists->isEmpty()) return response()->json('Movie with that title already exists.', 400);

        $movie = Movie::create([
            'title' => $request->title, 
            'slug' => Str::slug(strtolower($request->title))
        ]);

        return response()->json($movie, 200);
    }



    /**
     * Update existing movie.
     * @param Request $request
     */
    public function updateMovie(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'    => ['required'],
            'title'  => ['required', 'string', 'min:5'],
        ]);

        if($validator->fails()){
            return response()->json($validator->messages()->all(), 400);
        }

        $movie = Movie::find($request->id);
        if(!$movie) return response()->json('Not found', 404);

        $alreadyExists = Movie::where('title', $request->title)->get();
        if(!$alreadyExists->isEmpty()) return response()->json('Movie with that title already exists.', 400);
        
        $movie->title   = $request->title;
        $movie->slug    = Str::slug(strtolower($request->title));
        $movie->save();

        return response()->json($movie, 200);
    }



    /**
     * Delete movie.
     * @param Request $request
     */
    public function deleteMovie(Request $request)
    {
        if(!isset($request->id)) return response()->json('Bad request', 400);

        $movie = Movie::find($request->id);
        if(!$movie) return response()->json('Not found', 404);

        $movie->delete();
        return response()->json('Deleted.', 200);
    }
}
