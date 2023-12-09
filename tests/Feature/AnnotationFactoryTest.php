<?php

namespace Tests\Feature;

use App\Factories\AnnotationFactory;
use App\Factories\MatterFactory;
use App\Models\Annotation;
use App\Models\Law;
use App\Models\Matter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnotationFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testAnnotationBelongsToMatter(): void
    {
        $matter = (new MatterFactory())->create("matter", "#000000");
        $annotation = (new AnnotationFactory())->create($matter, "this is an annotation");
        $this->assertEquals($matter->id, $annotation->matter->id);
        $this->assertEquals(1, $annotation->matter->count());
    }

    public function testRelationshipWithLaw()
    {
        //Arrange
        $law = Law::factory()->create([
            'title'       => 'rijbewijs',
            'text'        => 'je mag een brommer met je B rijbewijs rijen',
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
        $annotation->laws()->attach($law, ['cursorIndex' => 222]);

        // Assert that the relationship exists in the pivot table
        $this->assertDatabaseHas('annotation_law', [
            'law_id'        => $law->id,
            'annotation_id' => $annotation->id,
        ]);
    }
}
