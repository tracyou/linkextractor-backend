<?php

namespace Tests\Feature;

use App\Factories\AnnotationFactory;
use App\Factories\MatterFactory;
use App\Factories\MatterRelationSchemaFactory;
use App\Factories\RelationSchemaFactory;
use App\Models\Annotation;
use App\Models\Article;
use App\Models\Matter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnotationFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testAnnotationBelongsToMatter(): void
    {
        $matterFactory = $this->app->make(MatterFactory::class);

        $matter = (new MatterFactory())->create("matter", "#000000");
        $relationSchema = (new RelationSchemaFactory())->create(true);
        $annotation = (new AnnotationFactory())->create(
            schema: $relationSchema,
            matter: $matter,
            text  : "this is an annotation"
        );
        $this->assertEquals($matter->id, $annotation->matter->id);
        $this->assertEquals(1, $annotation->matter->count());
    }

    public function testRelationshipWithArticle()
    {
        //Arrange
        $article = Article::factory()->create([
            'title'        => 'rijbewijs',
            'text'         => 'je mag een brommer met je B rijbewijs rijen',
            'is_published' => false,
        ]);

        $matter = Matter::factory()->create([
            'name'  => 'matter',
            'color' => '#001000',
        ]);

        $annotation = Annotation::factory()->create([
            'matter_id' => $matter->id,
            'text'      => 'this is an annotation',
        ]);

        //Act
        $annotation->article()->attach($article, ['cursor_index' => 222]);

        // Assert that the relationship exists in the pivot table
        $this->assertDatabaseHas('annotation_law', [
            'law_id'        => $article->id,
            'annotation_id' => $annotation->id,
        ]);
    }
}
