<?php

namespace Database\Seeders;

use App\Models\Law;
use App\Models\Matter;
use App\Models\Article;
use App\Models\Annotation;
use App\Models\RelationSchema;
use Illuminate\Database\Seeder;

class AnnotationSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        $matters = Matter::all();
        $article = Article::factory()->create([
            'law_id' => Law::factory()->create()->id,
        ]);

        foreach ($matters as $matter) {
            Annotation::factory()->count(2)->create([
                'matter_id'          => $matter->id,
                'relation_schema_id' => RelationSchema::first()->getKey(),
                'article_id'         => $article->id,
            ]);
        }
    }
}
