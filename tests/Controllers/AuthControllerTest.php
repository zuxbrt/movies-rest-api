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
        $this->json('post', '/api/login', 
        [
            "email" => "test@live.com",
            "password" => "test1234t"
        ])
        ->assertStatus(Response::HTTP_UNAUTHORIZED)
        ->assertContent('"Incorrect password."');
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
                'token',
                "user"  => [
                    "id" ,
                    "name",
                    "email"
                ]
            ]
        );
    }



    public function canRegisterWithInvalidParameters()
    {
        // $this->json('post', '/api/register', 
        // [
        //     "random" => "parameter"
        // ])->assertStatus(Response::HTTP_BAD_REQUEST)
        // ->assertJsonStructure(['*', '*']);
    }
}