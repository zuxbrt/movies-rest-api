<?php

namespace App\Services;

use Illuminate\Http\Request;
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
            'user'  => $user->id,
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
     * @return bool $status
     */
    public static function validateToken(string $token): bool
    {
        $decoded_token = null;

        try {
            $decoded_token = JWT::decode($token, new Key(env("APP_KEY"), 'HS256'));
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

        // handle non existing user
        if(!User::find($decoded_token->user)) return false;

        return true;
    }



    /**
     * Extract user id from JWT token.
     * ## NOTE:
     * ### Before calling this function, the token is already
     * ### being validated by the middleware - so we are skipping
     * ### any token validation.
     * 
     * @param Request $request
     */
    public static function getUserFromToken(Request $request)
    {
        $authorization_header = $request->header('Authorization');
        preg_match('/Bearer\s(\S+)/', $authorization_header, $matches);
        $token = $matches[1];
        $decoded_token = JWT::decode($token, new Key(env("APP_KEY"), 'HS256'));
        $user = User::find($decoded_token->user);
        return $user;
    }
}