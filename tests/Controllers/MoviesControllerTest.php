<?php

namespace Tests\Controllers;

use App\Models\Movie;
use Illuminate\Http\Response;
use Tests\TestCase;

class MoviesControllerTest extends TestCase
{



    protected function getJWTToken()
    {
        $response = $this->json('post', '/api/login', 
        [
            "email" => "test@live.com",
            "password" => "test1234"
        ]);
        
        return $response['token'];
    }



    public function testCanGetAllMovies()
    {
        $token = $this->getJWTToken();

        $this->json('get', 'api/movies', [], ['authorization' => 'Bearer ' . $token ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            [ "id", "title"]
        ]);
    }



    public function testCanGetMovieBySlug()
    {
        $token = $this->getJWTToken();

        $this->json('get', 'api/movies', ['slug' => 'avatar'], ['authorization' => 'Bearer ' . $token ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            "id", "title"
        ]);
    }



    public function testCanGetNonExistingMovieBySlug()
    {
        $token = $this->getJWTToken();

        $this->json('get', 'api/movies', ['slug' => 'abdcdef'], ['authorization' => 'Bearer ' . $token ])
        ->assertStatus(Response::HTTP_NOT_FOUND);
    }



    public function testCanGetPaginatedResults()
    {
        $token = $this->getJWTToken();

        $this->json('get', 'api/movies', [
            'page' => $this->faker->randomNumber(),
            'results' => $this->faker->randomNumber(),
            'orderby' => 'id',
            'order' => 'asc'
        ], ['authorization' => 'Bearer ' . $token ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            "numberOfPages" => [],
            "results" => []
        ]);
    }



    public function testCanAddAMovie()
    {
        $token = $this->getJWTToken();

        $this->json('post', '/api/movies', 
        [
            "title" => $this->faker->realText(10),
        ], ['authorization' => 'Bearer ' . $token ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(["title", "id"]);
    }


    public function testAddAMovieWithInvalidParameters()
    {
        $token = $this->getJWTToken();

        $this->json('post', '/api/movies', 
        [
            "title" => $this->faker->randomLetter
        ], ['authorization' => 'Bearer ' . $token ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['title'], null);
    }



    public function testCanUpdateMovie()
    {
        $token = $this->getJWTToken();
        $movie = Movie::first();

        $this->json('put', '/api/movies', 
        [
            "id" => $movie->id,
            "title" => $this->faker->realText(10),
        ], ['authorization' => 'Bearer ' . $token ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(["title", "id"]);
    }


    public function testUpdateMovieWithInvalidParameters()
    {
        $token = $this->getJWTToken();
        $movie = Movie::first();

        $this->json('put', '/api/movies', 
        [
            "id" => $movie->id,
            "title" => $this->faker->randomLetter
        ], ['authorization' => 'Bearer ' . $token ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['title'], null);
    }


    public function testCanDeleteAMovie()
    {
        $token = $this->getJWTToken();
        $movie = Movie::first();

        $this->json('delete', '/api/movies', ["id" => $movie->id], ['authorization' => 'Bearer ' . $token ])
        ->assertStatus(Response::HTTP_OK);
    }

}