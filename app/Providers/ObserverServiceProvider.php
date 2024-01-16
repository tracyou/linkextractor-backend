<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\ArticleRevision;
use App\Observers\ArticleRevisionObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        ArticleRevision::observe(ArticleRevisionObserver::class);
    }
}
