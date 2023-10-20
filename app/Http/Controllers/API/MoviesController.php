<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('');
    }


    /**
     * Get movies.
     * @param Request $request
     */
    public function getMovies(Request $request)
    {
        // get movies logic
        // pagination
        // query filters (name, created_at)
    }



    /**
     * Get single movie.
     * @param string $slug
     */
    public function getMovie(string $slug)
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
