<?php

namespace Tests\Feature;

use App\Factories\AnnotationFactory;
use App\Factories\MatterFactory;
use App\Models\Law;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotNull;

class AnnotationFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testAnnotationBelongsToMatter(): void
    {
        $matter = (new MatterFactory)->create("matter", "#000000");
        $annotation = (new AnnotationFactory)->create($matter, "this is an annotation");
        $this->assertEquals($matter->id, $annotation->matter->id);
        $this->assertEquals(1, $annotation->matter->count());
    }

    public function testRelationshipWithLaw()
    {
        $law = Law::factory()->create(["rijbewijs", "je mag een brommer met je B rijbewijs rijen", false]);
        $matter = (new MatterFactory)->create("matter", "#000000");
        $annotation = (new AnnotationFactory)->create($matter, "this is an annotation");

        $annotation->laws()->sync($annotation);

        $this->assertDatabaseHas('annotation_law', [
            'law_id' => $law->id,
            'annotation_id' => $annotation->id
        ]);
    }
}
