<?php

namespace Tests\Controllers;

use App\Models\Movie;
use Illuminate\Http\Response;
use Tests\TestCase;

class MoviesControllerTest extends TestCase
{



    public function testCanGetAllMovies()
    {
        $this->json('get', 'api/movies', [], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            [ "id", "title"]
        ]);
    }



    public function testCanGetMovieBySlug()
    {
        $movie = Movie::first();
        $this->json('get', 'api/movies', ['slug' => $movie->slug], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            "id", "title"
        ]);
    }



    public function testCanGetNonExistingMovieBySlug()
    {
        $this->json('get', 'api/movies', ['slug' => 'abdcdef'], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_NOT_FOUND);
    }



    public function testCanGetPaginatedResults()
    {
        $this->json('get', 'api/movies', [
            'page' => $this->faker->randomNumber(),
            'results' => $this->faker->randomNumber(),
            'orderby' => 'id',
            'order' => 'asc'
        ], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            "numberOfPages" => [],
            "results" => []
        ]);
    }



    public function testCanGetPaginatedResultsWithInvalidOrder()
    {
        $this->json('get', 'api/movies', [
            'page' => $this->faker->randomNumber(),
            'results' => $this->faker->randomNumber(),
            'orderby' => 'id',
            'order' => $this->faker->word()
        ], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_BAD_REQUEST);
    }



    public function testCanGetPaginatedResultsWithInvalidOrderColumn()
    {
        $this->json('get', 'api/movies', [
            'page' => $this->faker->randomNumber(),
            'results' => $this->faker->randomNumber(),
            'orderby' => $this->faker->word(),
            'order' => 'desc'
        ], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_BAD_REQUEST);
    }



    public function testCanGetPaginatedResultsWithInvalidPage()
    {
        $this->json('get', 'api/movies', [
            'page' => $this->faker->numberBetween(-100, 0),
            'results' => 1,
            'orderby' => $this->faker->word(),
            'order' => 'desc'
        ], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testCanGetPaginatedResultsWithInvalidResultsCount()
    {
        $this->json('get', 'api/movies', [
            'page' => $this->faker->numberBetween(-100, 0),
            'results' => 5,
            'orderby' => $this->faker->word(),
            'order' => 'desc'
        ], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testCanAddAMovie()
    {
        $this->json('post', '/api/movies', 
        [
            "title" => $this->faker->realText(10) . ' - ' . $this->faker->realText(10),
        ], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(["title", "id"]);
    }


    public function testAddAMovieWithInvalidParameters()
    {
        $this->json('post', '/api/movies', 
        [
            "title" => $this->faker->randomLetter
        ], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['title'], null);
    }



    public function testCanUpdateMovie()
    {
        $movie = Movie::first();

        $this->json('put', '/api/movies', 
        [
            "id" => $movie->id,
            "title" => $movie->title . $this->faker->realText(10),
        ], ['authorization' => 'Bearer ' .$this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(["id", "title"]);
    }


    public function testUpdateMovieWithInvalidParameters()
    {
        $movie = Movie::first();

        $this->json('put', '/api/movies', 
        [
            "id" => $movie->id,
            "title" => $this->faker->randomLetter
        ], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['title'], null);
    }


    public function testCanDeleteAMovie()
    {
        $movie = Movie::first();

        $this->json('delete', '/api/movies', ["id" => $movie->id], ['authorization' => 'Bearer ' . $this->JWTtoken ])
        ->assertStatus(Response::HTTP_OK);
    }

}