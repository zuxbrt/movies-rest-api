<?php

namespace Tests\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Tests\TestCase;

class JWTServiceTest extends TestCase
{



    public function testGetMoviesWithInvalidJWT()
    {
       $this->json('get', 'api/movies', [], ['authorization' => 'Bearer ' . $this->faker->realText(45) ])
        ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }


    public function testGetMoviesWithExpiredJWT()
    {
        Carbon::setTestNow(Carbon::now()->addMonth());
        $this->json('get', 'api/movies', [], ['authorization' => 'Bearer ' . $this->JWTtoken ])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

}