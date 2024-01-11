<?php

namespace Tests\Feature;

use App\Models\Law;
use Tests\TestCase;
use App\Models\Matter;
use App\Models\Article;
use App\Models\Annotation;
use App\Factories\MatterFactory;
use App\Factories\AnnotationFactory;
use App\Factories\RelationSchemaFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnnotationFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testAnnotationBelongsToMatter(): void
    {
        $matterFactory = $this->app->make(MatterFactory::class);

        $matter = (new MatterFactory())->create("matter", "#000000");
        $article = Article::factory()->create(['law_id' => Law::factory()->create()->id]);
        $relationSchema = (new RelationSchemaFactory())->create(true);
        $annotation = (new AnnotationFactory())->create(
            schema: $relationSchema,
            article: $article,
            matter: $matter,
            text: "this is an annotation",
        );
        $this->assertEquals($matter->id, $annotation->matter->id);
        $this->assertEquals(1, $annotation->matter->count());
    }

    public function testRelationshipWithLaw()
    {
        //Arrange
        $law = Law::factory()->create([
            'title'        => 'rijbewijs',
            'is_published' => false,
        ]);

        $matter = Matter::factory()->create([
            'name'  => 'matter',
            'color' => '#001000',
        ]);

        $article = Article::factory()->create([
            'law_id' => $law->id,
        ]);

        $annotation = Annotation::factory()->create([
            'matter_id' => $matter->id,
            'article_id' => $article->id,
            'text'      => 'this is an annotation',
        ]);

        //Act
        $annotation->article()->associate($article);

        // Assert that the relationship exists in the tables
        $this->assertDatabaseHas('articles', [
            'law_id' => $law->id,
        ]);
        $this->assertDatabaseHas('annotations', [
            'article_id' => $article->id,
        ]);
    }
}
