<?php

namespace App\Providers;

use App\Contracts\Factories\LawAnnotationsPivotFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\PancakeFactoryInterface;
use App\Contracts\Factories\PancakeStackFactoryInterface;
use App\Factories\LawAnnotationPivotPivotFactory;
use App\Factories\LawFactory;
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
    }
}
