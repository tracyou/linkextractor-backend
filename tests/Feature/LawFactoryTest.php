<?php

namespace Tests\Feature;

use App\Models\Annotation;
use App\Models\Law;
use App\Models\Matter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LawFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateLaw()
    {
        // Arrange create law object
        $law = Law::factory()->create(["title" => "rijbewijs", "text" => "je mag een brommer met je B rijbewijs rijen", "is_published" => false]);

        // Act
        $title = $law->title;
        $text = $law->text;
        $isPublished = $law->is_published;

        // Assert
        $this->assertInstanceOf(Law::class, $law, 'Created object should be an instance of Law');
        $this->assertEquals("rijbewijs", $title, 'Title should be set correctly');
        $this->assertEquals("je mag een brommer met je B rijbewijs rijen", $text, 'Text should be set correctly');
        $this->assertEquals(false, $isPublished, 'isPublished should be set correctly');
    }

    public function testRelationWithAnnotation()
    {
        //Arrange
        $law = Law::factory()->create([
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
        $law->annotations()->attach($annotation, ['cursor_index' => 22]);

        // Assert that the relationship exists in the pivot table
        $this->assertDatabaseHas('annotation_law', [
            'law_id'        => $law->id,
            'annotation_id' => $annotation->id,
        ]);
    }
}