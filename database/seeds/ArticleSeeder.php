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
        $law = Law::first();
        Article::factory()->count(5)->create();
    }
}
