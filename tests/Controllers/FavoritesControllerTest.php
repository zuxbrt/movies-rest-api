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



    // public function testCanAddMovieToFavorites()
    // {
    //     $addedFavorites = Favorites::all();
    //     $this->json('post', 'api/favorites', [], ['authorization' => 'Bearer ' . $this->JWTtoken ])
    //     ->dump()
    //     ->assertStatus(Response::HTTP_OK)
    //     ->assertJsonStructure([]);
    // }



    // public function testCanRemoveMovieToFavorites()
    // {
    //     $this->json('delete', 'api/favorites', [], ['authorization' => 'Bearer ' . $this->JWTtoken ])
    //     ->dump()
    //     ->assertStatus(Response::HTTP_OK)
    //     ->assertJsonStructure([]);
    // }
}