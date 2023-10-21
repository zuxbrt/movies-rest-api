<?php

namespace App\Http\Controllers\API;

use App\Helpers\Pagination;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth-api');
    }


    /**
     * Get movies.
     * @param Request $request
     */
    public function all(Request $request)
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
        } else {
            return response()->json(Movie::all(), 200);
        }
        
    }



    /**
     * Get single movie.
     * @param string $slug
     */
    public function single(string $slug)
    {
        // get movie logic
    }



    /**
     * Add a movie.
     * @param Request $request
     */
    public function addMovie(Request $request)
    {
        // add movie logic
    }



    /**
     * Update existing movie.
     * @param Request $request
     */
    public function updateMovie(Request $request)
    {
        // update movie logic
    }



    /**
     * Delete movie.
     * @param int $id
     */
    public function deleteMovie(int $id)
    {
        // delete movie logic
    }
}
