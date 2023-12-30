<?php

use Database\Seeders\AnnotationSeeder;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\FileXmlSeeder;
use Database\Seeders\LawAnnotationPivotSeeder;
use Database\Seeders\LawSeeder;
use Database\Seeders\MatterRelationSchemaSeeder;
use Database\Seeders\MatterRelationSeeder;
use Database\Seeders\MatterSeeder;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\RelationSchemaSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MatterSeeder::class,
            RelationSchemaSeeder::class,
            MatterRelationSchemaSeeder::class,
            MatterRelationSeeder::class,
            AnnotationSeeder::class,
            LawSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
