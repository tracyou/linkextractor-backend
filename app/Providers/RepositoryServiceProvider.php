<?php

namespace App\Providers;

use App\Contracts\Repositories\ApplicationComponentRepositoryInterface;
use App\Contracts\Repositories\ApplicationRepositoryInterface;
use App\Contracts\Repositories\BaseComponentRepositoryInterface;
use App\Contracts\Repositories\CompanyRepositoryInterface;
use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\ApplicationComponentRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\BaseComponentRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\PancakeRepository;
use App\Repositories\PancakeStackRepository;
use App\Repositories\UserRepository;
use Wimski\ModelRepositories\Providers\ModelRepositoryServiceProvider;

class RepositoryServiceProvider extends ModelRepositoryServiceProvider
{
    protected array $repositories = [
        PancakeRepositoryInterface::class => PancakeRepository::class,
        PancakeStackRepositoryInterface::class => PancakeStackRepository::class,
    ];
}
