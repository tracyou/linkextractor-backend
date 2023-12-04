<?php

namespace Tests\Feature;

use App\Factories\AnnotationFactory;
use App\Factories\MatterFactory;
use App\Factories\MatterRelationFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatterFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testMatterHasManyAnnotations(): void
    {
        $matter = (new MatterFactory)->create("matter", "#000000");
        $annotation = (new AnnotationFactory)->create($matter, "this is an annotation");
        $this->assertEquals(1, $matter->annotations->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $matter->annotations);
    }

    public function testMatterHasManyRelations(): void
    {
        $matterA = (new MatterFactory)->create("matter1", "#000000");
        $matterB = (new MatterFactory)->create("matter2", "#000000");
        (new MatterRelationFactory)->create($matterA, $matterB, "requires 1", "description");
        $this->assertEquals(1, $matterA->matterRelationsParents->count());
        $this->assertEquals(1, $matterB->matterRelationsChilds->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $matterA->matterRelationsParents);
    }
}
