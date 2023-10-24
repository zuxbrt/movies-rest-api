<?php

namespace Tests\Controllers;

use App\Models\Movie;
use App\Models\User\Following;
use Illuminate\Http\Response;
use Tests\TestCase;

class FollowingControllerTest extends TestCase
{


    
    public function testCanGetFollowing()
    {
        $this->json('get', 'api/following', [], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([]);
    }



    public function testCanFollowAMovie()
    {
        $followingMovies = Following::where('user_id', $this->user->id)->select('id')->get()->pluck('id')->toArray();
        $notFollowing = Movie::whereNotIn('id', $followingMovies)->get()->first();
        $this->json('post', 'api/following', ['movie_id' => $notFollowing->id], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK);
    }



    public function testCanUnfollowAMovie()
    {
        $Following = Following::where('user_id', $this->user->id)->get()->first();
        $this->json('delete', 'api/following', ['movie_id' => $Following->movie_id], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK);
    }
}