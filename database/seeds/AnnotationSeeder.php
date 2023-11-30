<?php

namespace Database\Seeders;

use App\Models\Annotation;
use Illuminate\Database\Seeder;

class AnnotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Annotation::factory()
            ->count(20);
    }
}
