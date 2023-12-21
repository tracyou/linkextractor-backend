<?php

namespace Tests\Feature;

use App\Models\Annotation;
use App\Models\Article;
use App\Models\Law;
use App\Models\Matter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LawFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_law()
    {
        // Arrange create law object
        $law = Law::factory()->create(["title" => "rijbewijs", "is_published" => false]);

        // Act
        $title = $law->title;
        $isPublished = $law->is_published;

        // Assert
        $this->assertInstanceOf(Law::class, $law, 'Created object should be an instance of Law');
        $this->assertEquals("rijbewijs", $title, 'Title should be set correctly');
        $this->assertFalse($isPublished, 'isPublished should be set correctly');
    }


    public function test_relation_with_articles()
    {
        //Arrange
        $law = Law::factory()->create([
            'title'       => 'rijbewijs',
            'is_published' => false,
        ]);

        $article = Article::factory()->create([
            'title'=> 'this is the title',
            'text'=> 'this is the text',
        ]);


        //Act
        $law->articles()->save($article);

        // Assert that the relationship exists in the articles table
        $this->assertDatabaseHas('articles', [
            'law_id'        => $law->id,
        ]);
    }



}
