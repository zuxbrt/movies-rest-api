<?php

namespace Tests\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Tests\TestCase;

class APIAuthMiddlewareTest extends TestCase
{



    public function testMissingAuthorizationHeader()
    {
       $this->json('get', 'api/movies', [], [])
        ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testInvalidAuthorizationHeader()
    {
       $this->json('get', 'api/movies', [], ['authorization' => $this->faker->word()])
        ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testMissingTokenInAuthorizationHeader()
    {
       $this->json('get', 'api/movies', [], ['authorization' => 'Bearer' . '&nbsp;' . '&nbsp;'])
        ->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}