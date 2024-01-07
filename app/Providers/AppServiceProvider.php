<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Annotation;
use App\Models\Article;
use App\Models\Law;
use App\Models\Matter;
use App\Models\MatterRelation;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Relation::enforceMorphMap([
            'matter'         => Matter::class,
            'annotation'     => Annotation::class,
            'matterRelation' => MatterRelation::class,
            'article'        => Article::class,
            'law'            => Law::class,
        ]);
    }
}
