<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Law;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Law::all() as $law) {
            Article::factory()->count(5)->create([
                'law_id' => $law->id,
            ]);
        }
    }
}
