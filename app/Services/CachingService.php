<?php

namespace App\Services;

use App\Services\JWTService;
use Illuminate\Support\Facades\Cache;

class CachingService
{
    public static function getCachedFavorites()
    {
        $user = JWTService::getUserFromToken(request());
        return Cache::get($user->id);
    }

    public static function cacheFavorites()
    {
        $user = JWTService::getUserFromToken(request());
        if(!$user->favorites()->isEmpty()){
            Cache::put($user->id, $user->favorites());
        }
    }
}