<?php

namespace App\Observers;

use App\Models\User\Favorites;
use App\Services\CachingService;


class UserFavoritesObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Favorites "created" event.
     */
    public function created(Favorites $favorites): void
    {
        CachingService::cacheFavorites();
    }

    // /**
    //  * Handle the Favorites "updated" event.
    //  */
    // public function updated(Favorites $favorites): void
    // {
    // }

    /**
     * Handle the Favorites "deleted" event.
     */
    public function deleted(Favorites $favorites): void
    {
        CachingService::cacheFavorites();
    }

    // /**
    //  * Handle the Favorites "restored" event.
    //  */
    // public function restored(Favorites $favorites): void
    // {
    // }

    // /**
    //  * Handle the Favorites "force deleted" event.
    //  */
    // public function forceDeleted(Favorites $favorites): void
    // {
    // }
}
