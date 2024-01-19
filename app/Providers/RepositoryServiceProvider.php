<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Repositories\AnnotationRepositoryInterface;
use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Contracts\Repositories\ArticleRevisionRepositoryInterface;
use App\Contracts\Repositories\LawRepositoryInterface;
use App\Contracts\Repositories\MatterRelationRepositoryInterface;
use App\Contracts\Repositories\MatterRelationSchemaRepositoryInterface;
use App\Contracts\Repositories\MatterRepositoryInterface;
use App\Contracts\Repositories\RelationSchemaRepositoryInterface;
use App\Repositories\AnnotationRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRevisionRepository;
use App\Repositories\LawRepository;
use App\Repositories\MatterRelationRepository;
use App\Repositories\MatterRelationSchemaRepository;
use App\Repositories\MatterRepository;
use App\Repositories\RelationSchemaRepository;
use Wimski\ModelRepositories\Providers\ModelRepositoryServiceProvider;

/**
 * @codeCoverageIgnore
 */
class RepositoryServiceProvider extends ModelRepositoryServiceProvider
{
    protected array $repositories = [
        LawRepositoryInterface::class                  => LawRepository::class,
        MatterRepositoryInterface::class               => MatterRepository::class,
        AnnotationRepositoryInterface::class           => AnnotationRepository::class,
        MatterRelationSchemaRepositoryInterface::class => MatterRelationSchemaRepository::class,
        RelationSchemaRepositoryInterface::class       => RelationSchemaRepository::class,
        ArticleRepositoryInterface::class              => ArticleRepository::class,
        MatterRelationRepositoryInterface::class       => MatterRelationRepository::class,
        ArticleRevisionRepositoryInterface::class      => ArticleRevisionRepository::class,
    ];
}
