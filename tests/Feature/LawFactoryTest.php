<?php

namespace Feature;

use App\Factories\AnnotationFactory;
use App\Factories\LawFactory;
use App\Factories\MatterFactory;
use App\Models\Annotation;
use App\Models\Law;
use App\Models\Matter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Monolog\Test\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class LawFactoryTest extends TestCase
{
    use RefreshDatabase;
    public function testCreateLaw()
    {
        $law = Law::factory()->create(["rijbewijs", "je mag een brommer met je B rijbewijs rijen", false]);
        assertEquals("rijbewijs", $law->title);
        assertEquals("je mag een brommer met je B rijbewijs rijen", $law->text);
        assertEquals(false, $law->isPublished);
    }

    public function testRelationWithAnnotation()
    {
        $law = Law::factory()->create(["rijbewijs", "je mag een brommer met je B rijbewijs rijen", false]);
        $matter = Matter::factory()->create(["matter", "#000000"]);
        $annotation = Annotation::factory()->create([$matter, "this is an annotation"]);

        assertNotNull($annotation->laws()->withPivot(['cursorIndex'])->get());


    }






}
