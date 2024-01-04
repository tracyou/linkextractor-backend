<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Repositories\AnnotationRepositoryInterface;
use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Contracts\Repositories\FileXmlRepositoryInterface;
use App\Contracts\Repositories\LawRepositoryInterface;
use App\Contracts\Repositories\MatterRelationRepositoryInterface;
use App\Contracts\Repositories\MatterRelationSchemaRepositoryInterface;
use App\Contracts\Repositories\MatterRepositoryInterface;
use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Contracts\Repositories\RelationSchemaRepositoryInterface;
use App\Repositories\AnnotationRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\FileXmlRepository;
use App\Repositories\LawRepository;
use App\Repositories\MatterRelationRepository;
use App\Repositories\MatterRelationSchemaRepository;
use App\Repositories\MatterRepository;
use App\Repositories\PancakeRepository;
use App\Repositories\PancakeStackRepository;
use App\Repositories\RelationSchemaRepository;
use Wimski\ModelRepositories\Providers\ModelRepositoryServiceProvider;

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
        ArticleRepositoryInterface::class => ArticleRepository::class,
        FileXmlRepositoryInterface::class => FileXmlRepository::class,
        MatterRelationRepositoryInterface::class => MatterRelationRepository::class,

    ];
}
