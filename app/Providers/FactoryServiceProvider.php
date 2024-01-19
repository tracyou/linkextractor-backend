<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\ArticleRevisionFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Contracts\Factories\RelationSchemaFactoryInterface;
use App\Factories\AnnotationFactory;
use App\Factories\ArticleFactory;
use App\Factories\ArticleRevisionFactory;
use App\Factories\LawFactory;
use App\Factories\MatterFactory;
use App\Factories\MatterRelationFactory;
use App\Factories\MatterRelationSchemaFactory;
use App\Factories\RelationSchemaFactory;
use Illuminate\Support\ServiceProvider;

class FactoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LawFactoryInterface::class, LawFactory::class);
        $this->app->singleton(MatterFactoryInterface::class, MatterFactory::class);
        $this->app->singleton(MatterRelationFactoryInterface::class, MatterRelationFactory::class);
        $this->app->singleton(AnnotationFactoryInterface::class, AnnotationFactory::class);
        $this->app->singleton(MatterRelationSchemaFactoryInterface::class, MatterRelationSchemaFactory::class);
        $this->app->singleton(RelationSchemaFactoryInterface::class, RelationSchemaFactory::class);
        $this->app->singleton(ArticleFactoryInterface::class, ArticleFactory::class);
        $this->app->singleton(ArticleRevisionFactoryInterface::class, ArticleRevisionFactory::class);
    }
}
