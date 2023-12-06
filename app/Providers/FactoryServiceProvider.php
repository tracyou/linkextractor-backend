<?php

namespace App\Providers;

use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationFactoryInterface;
use App\Contracts\Factories\PancakeFactoryInterface;
use App\Contracts\Factories\PancakeStackFactoryInterface;
use App\Factories\AnnotationFactory;
use App\Factories\LawFactory;
use App\Factories\MatterFactory;
use App\Factories\MatterRelationFactory;
use App\Factories\PancakeFactory;
use App\Factories\PancakeStackFactory;
use Illuminate\Support\ServiceProvider;

class FactoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PancakeFactoryInterface::class, PancakeFactory::class);
        $this->app->singleton(PancakeStackFactoryInterface::class, PancakeStackFactory::class);
        $this->app->singleton(LawFactoryInterface::class, LawFactory::class);
        $this->app->singleton(MatterFactoryInterface::class, MatterFactory::class);
        $this->app->singleton(MatterRelationFactoryInterface::class, MatterRelationFactory::class);
        $this->app->singleton(AnnotationFactoryInterface::class, AnnotationFactory::class);
    }
}
