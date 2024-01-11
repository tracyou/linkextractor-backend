<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\LawRepository;
use App\Repositories\MatterRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\PancakeRepository;
use App\Repositories\AnnotationRepository;
use App\Repositories\PancakeStackRepository;
use App\Repositories\RelationSchemaRepository;
use App\Repositories\MatterRelationSchemaRepository;
use App\Contracts\Repositories\LawRepositoryInterface;
use App\Contracts\Repositories\MatterRepositoryInterface;
use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Contracts\Repositories\AnnotationRepositoryInterface;
use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Contracts\Repositories\RelationSchemaRepositoryInterface;
use Wimski\ModelRepositories\Providers\ModelRepositoryServiceProvider;
use App\Contracts\Repositories\MatterRelationSchemaRepositoryInterface;

class RepositoryServiceProvider extends ModelRepositoryServiceProvider
{
    protected array $repositories = [
        PancakeRepositoryInterface::class              => PancakeRepository::class,
        PancakeStackRepositoryInterface::class         => PancakeStackRepository::class,
        ArticleRepositoryInterface::class              => ArticleRepository::class,
        LawRepositoryInterface::class                  => LawRepository::class,
        MatterRepositoryInterface::class               => MatterRepository::class,
        AnnotationRepositoryInterface::class           => AnnotationRepository::class,
        MatterRelationSchemaRepositoryInterface::class => MatterRelationSchemaRepository::class,
        RelationSchemaRepositoryInterface::class       => RelationSchemaRepository::class,
    ];
}
