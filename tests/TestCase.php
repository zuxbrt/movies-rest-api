<?php

namespace Tests;

use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    private Generator $faker;
    private string $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        // clear cache
        Artisan::call('cache:clear');
        Artisan::call('migrate:fresh --seed');

        $response = $this->json('post', '/api/login', 
        [
            "email" => "test@live.com",
            "password" => "test1234"
        ]);
        
        $this->token = $response['token'];
    }

    public function __get($key)
    {
        if($key === 'faker'){
            return $this->faker;
        }
        if($key === 'JWTtoken'){
            return $this->token;
        }
        throw new Exception('Unknown key requested');
    }
}
