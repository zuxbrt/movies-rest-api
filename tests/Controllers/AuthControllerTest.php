<?php

namespace Tests\Controllers;

use Illuminate\Http\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function testCanUserLogin()
    {
        $this->json('post', '/api/login', 
        [
            "email" => "test@live.com",
            "password" => "test1234"
        ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'token' => "*",
                "user"  => [
                    "id" => "*",
                    "name" => "*",
                    "email" => "*"
                ]
            ]
        );
    }

    public function testCanUserRegister()
    {
        $this->json('post', '/api/register', 
        [
            "name" => "haso hasic",
            "email" => "haso@live.com",
            "password" => "haso4321"
        ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'token' => "*",
                "user"  => [
                    "id" => "*",
                    "name" => "*",
                    "email" => "*"
                ]
            ]
        );
    }
}