<?php

declare(strict_types=1);

namespace Integration\Factories;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Models\Article;
use App\Models\Law;
use App\Models\Matter;
use App\Models\RelationSchema;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class AnnotationFactoryTest extends AbstractHttpGraphQLTestCase
{
    public AnnotationFactoryInterface $annotationFactory;

    public function setUp(): void
    {
        parent::setUp();

        // Inject the annotation factory as preparation for each test
        $this->annotationFactory = $this->app->make(AnnotationFactoryInterface::class);
    }

    /**
     * @test
     */
    public function test_annotation_belongs_to_matter(): void
    {
        // Arrange
        $matter = Matter::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        $law = Law::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        $relationSchema = RelationSchema::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        $article = Article::factory()->create([
            'id'     => $this->createUUIDFromID(1),
            'law_id' => $law->id,
        ]);

        //Act
        $annotation = $this->annotationFactory->create(
            $matter,
            'this is an annotation',
            'this is the definition of the annotation',
            'this is a comment',
            1,
            $article,
            $relationSchema
        );

        // Assert
        $this->assertDatabaseHas('annotations', [
            'id'         => $annotation->id,
            'article_id' => $this->createUUIDFromID(1),
            'matter_id'  => $this->createUUIDFromID(1),
            'text'       => 'this is an annotation',
        ]);

        $this->assertEquals(1, $matter->annotations->count());
        $this->assertEquals($annotation->article->law->id, $this->createUUIDFromID(1));
    }
}
