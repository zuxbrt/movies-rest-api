<?php

namespace Tests\Controllers;

use App\Models\User;
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
                'token',
                "user"  => [
                    "id" ,
                    "name",
                    "email"
                ]
            ]
        );
    }



    public function testCanUserLoginWithInvalidCredentials()
    {
        $user = User::first();
        $this->json('post', '/api/login', 
        [
            "email" => $user->email,
            "password" => $this->faker->password
        ])
        ->assertStatus(Response::HTTP_UNAUTHORIZED)
        ->assertContent('"Incorrect password."');
    }



    public function testCanUserRegister()
    {
        $this->json('post', '/api/register', 
        [
            "name" => $this->faker->name,
            "email" => $this->faker->email,
            "password" => $this->faker->password(8)
        ])
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'token',
                "user"  => [
                    "id" ,
                    "name",
                    "email"
                ]
            ]
        );
    }



    public function testCanRegisterWithInvalidParameters()
    {
        $this->json('post', '/api/register', 
        [
            "random" => "parameter"
        ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['email', 'password'], null);
    }



    public function testLoginWithInvalidParameters()
    {
        $this->json('post', '/api/login', 
        [
            "random" => "parameter"
        ])
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['email', 'password'], null);
    }
}