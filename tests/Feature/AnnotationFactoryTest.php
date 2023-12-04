<?php

namespace Tests\Feature;

use App\Factories\AnnotationFactory;
use App\Factories\MatterFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnotationFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testAnnotationBelongsToMatter(): void
    {
        $matter = (new MatterFactory)->create("matter", "#000000");
        $annotation = (new AnnotationFactory)->create($matter, "this is an annotation");
        $this->assertEquals(1, $annotation->matter->count());
    }
}
