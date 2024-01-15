<?php

declare(strict_types=1);

namespace Integration\Repositories;

use App\Contracts\Repositories\AnnotationRepositoryInterface;
use App\Models\Annotation;
use App\Models\Article;
use App\Models\Law;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class AnnotationRepositoryTest extends AbstractHttpGraphQLTestCase
{
    public AnnotationRepositoryInterface $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(AnnotationRepositoryInterface::class);
    }

    public function testGetNewRevisionNumber(): void
    {
        $law = Law::factory()->create([
            'id' => $this->createUUIDFromID(1)
        ]);

        $article = Article::factory()->create([
            'id' => $this->createUUIDFromID(1),
            'law_id' => $law->id,
        ]);

        $this->assertEquals(1, $this->repository->getNewRevisionNumber($law));

        Annotation::factory()->create([
            'article_id' => $article->id,
            'revision_number' => 1,
        ]);

        $law->refresh();

        $this->assertEquals(2, $this->repository->getNewRevisionNumber($law));
    }
}
