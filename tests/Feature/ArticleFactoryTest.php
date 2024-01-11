<?php

namespace Tests\Feature;

use App\Models\Law;
use Tests\TestCase;
use App\Models\Matter;
use App\Models\Article;
use App\Models\Annotation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LawFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateLaw()
    {
        // Arrange create law object
        $law = Law::factory()->create(["title" => "rijbewijs", "is_published" => false]);

        // Act
        $title = $law->title;
        $isPublished = $law->is_published;

        // Assert
        $this->assertInstanceOf(Law::class, $law, 'Created object should be an instance of Law');
        $this->assertEquals("rijbewijs", $title, 'Title should be set correctly');
        $this->assertEquals(false, $isPublished, 'isPublished should be set correctly');
    }
}
