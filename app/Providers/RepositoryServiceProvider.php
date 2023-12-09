<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Repositories\PancakeRepository;
use App\Repositories\PancakeStackRepository;
use Wimski\ModelRepositories\Providers\ModelRepositoryServiceProvider;

class RepositoryServiceProvider extends ModelRepositoryServiceProvider
{
    protected array $repositories = [
        PancakeRepositoryInterface::class      => PancakeRepository::class,
        PancakeStackRepositoryInterface::class => PancakeStackRepository::class,
    ];
}
