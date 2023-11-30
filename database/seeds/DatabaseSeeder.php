<?php

use Database\Seeders\AnnotationSeeder;
use Database\Seeders\LawSeeder;
use Database\Seeders\MatterRelationSeeder;
use Database\Seeders\MatterSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PancakeStackSeeder::class,
            MatterSeeder::class,
            MatterRelationSeeder::class,
            AnnotationSeeder::class,
            LawSeeder::class,
        ]);
    }
}
