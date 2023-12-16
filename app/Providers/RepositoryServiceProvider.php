<?php

namespace App\Providers;

use App\Contracts\Repositories\AnnotationRepositoryInterface;
use App\Contracts\Repositories\FileXmlRepositoryInterface;
use App\Contracts\Repositories\LawRepositoryInterface;
use App\Contracts\Repositories\MatterRelationRepositoryInterface;
use App\Contracts\Repositories\MatterRepositoryInterface;
use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Repositories\AnnotationRepository;
use App\Repositories\FileXmlRepository;
use App\Repositories\LawRepository;
use App\Repositories\MatterRepository;
use App\Repositories\PancakeRepository;
use App\Repositories\PancakeStackRepository;
use Wimski\ModelRepositories\Providers\ModelRepositoryServiceProvider;

class RepositoryServiceProvider extends ModelRepositoryServiceProvider
{
    protected array $repositories = [
        PancakeRepositoryInterface::class => PancakeRepository::class,
        PancakeStackRepositoryInterface::class => PancakeStackRepository::class,
        AnnotationRepositoryInterface::class => AnnotationRepository::class,
        LawRepositoryInterface::class => LawRepository::class,
        MatterRelationRepositoryInterface::class => MatterRelationRepositoryInterface::class,
        MatterRepositoryInterface::class => MatterRepository::class,
        FileXmlRepositoryInterface::class => FileXmlRepository::class,

    ];
}
