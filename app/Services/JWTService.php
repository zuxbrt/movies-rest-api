<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{
    /**
     * Form JWT for user.
     * 
     * @param User $user
     * @return string $jwt
     */
    public function getEncodedTokenForUser(User $user): string
    {
        $key = env('APP_KEY');
        $payload = [
            'iss'   => env('APP_URL', 'localhost:8000'),      // issuer claim
            'nbf'   => Carbon::now()->timestamp,              // not before
            'iat'   => Carbon::now()->timestamp,              // issued at
            'exp'   => Carbon::now()->addWeek()->timestamp,   // expires (week),
            'email' => $user->email
        ];

        // Encode headers in the JWT string
        $headers = null;
        $jwt = JWT::encode($payload, $key, 'HS256', null, $headers);

        // $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        // print_r($decoded);

        return $jwt;
    }
}