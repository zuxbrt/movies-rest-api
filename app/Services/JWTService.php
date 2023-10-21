<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{
    # https://github.com/firebase/php-jwt
    # https://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#RegisteredClaimName


    /**
     * Form JWT for user.
     * 
     * @param User $user
     * @return string $jwt
     */
    public static function getTokenForUser(User $user): string
    {
        $key = env('APP_KEY');
        $payload = [
            'iss'   => env('APP_URL'),                      // issuer claim
            'nbf'   => Carbon::now()->timestamp,            // not before
            'iat'   => Carbon::now()->timestamp,            // issued at
            'exp'   => Carbon::now()->addWeek()->timestamp, // expires (in a week),
            'user'  => str_replace(" ", "", $user->name),
        ];

        // Encode headers in the JWT string - currently empty
        $headers = null;
        $jwt = JWT::encode($payload, $key, 'HS256', null, $headers);

        return $jwt;
    }



    /**
     * Validate token.
     * 
     * @param string $token
     * @return int $status
     */
    public static function validateToken(string $token): int
    {
        $decoded_token = null;

        try {
            $decoded_token = JWT::decode($token, new Key(env("APP_KEY"), 'HS256'));
        } catch (\Firebase\JWT\ExpiredException $e) {
            // exipred token
            return false;
        } catch (Exception $e) {
            // invalid signature
            return false;
        }

        if ($decoded_token->iss !== env('APP_URL') ||
            $decoded_token->nbf > Carbon::now()->timestamp ||
            $decoded_token->exp < Carbon::now()->timestamp )
        {
            return false;
        }

        return true;
    }
}