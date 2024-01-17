<?php

declare(strict_types=1);

namespace Integration\Observers;

use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\Law;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class ArticleRevisionObserverTest extends AbstractHttpGraphQLTestCase
{
    /**
     * @test
     */
    public function it_creates_an_article_revision_and_sets_revision_number(): void
    {
        $law = Law::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        Article::factory()->create([
            'id' => $this->createUUIDFromID(1),
            'law_id' => $this->createUUIDFromID(1),
        ]);

        ArticleRevision::factory()->create([
            'id' => $this->createUUIDFromID(1),
            'article_id' => $this->createUUIDFromID(1),
        ]);

        $this->assertDatabaseHas('article_revisions', [
            'id' => $this->createUUIDFromID(1),
            'article_id' => $this->createUUIDFromID(1),
            'revision' => 1,
        ]);

        ArticleRevision::factory()->create([
            'id' => $this->createUUIDFromID(2),
            'article_id' => $this->createUUIDFromID(1),
        ]);

        $this->assertDatabaseHas('article_revisions', [
            'id' => $this->createUUIDFromID(2),
            'article_id' => $this->createUUIDFromID(1),
            'revision' => 1,
        ]);

        $law->revision = 1;
        $law->save();

        ArticleRevision::factory()->create([
            'id' => $this->createUUIDFromID(3),
            'article_id' => $this->createUUIDFromID(1),
        ]);

        $this->assertDatabaseHas('article_revisions', [
            'id' => $this->createUUIDFromID(3),
            'article_id' => $this->createUUIDFromID(1),
            'revision' => 2,
        ]);
    }
}
