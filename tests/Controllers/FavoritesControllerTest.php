<?php

namespace Tests\Controllers;

use App\Models\Movie;
use App\Models\User\Favorites;
use Illuminate\Http\Response;
use Tests\TestCase;

class FavoritesControllerTest extends TestCase
{


    
    public function testCanGetFavorites()
    {
        $this->json('get', 'api/favorites', [], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([]);
    }



    public function testCanAddMovieToFavorites()
    {
        $addedFavorites = Favorites::where('user_id', $this->user->id)->select('id')->get()->pluck('id')->toArray();
        $notInFavorites = Movie::whereNotIn('id', $addedFavorites)->get()->first();
        $this->json('post', 'api/favorites', ['movie_id' => $notInFavorites->id], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK);
    }



    public function testCanRemoveMovieToFavorites()
    {
        $favorite = Favorites::where('user_id', $this->user->id)->get()->first();
        $this->json('delete', 'api/favorites', ['movie_id' => $favorite->movie_id], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK);
    }
}