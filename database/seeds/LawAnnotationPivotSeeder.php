<?php

namespace Database\Seeders;

use App\Models\Annotation;
use App\Models\Law;
use App\Models\LawAnnotationPivot;
use Illuminate\Database\Seeder;

class LawAnnotationPivotSeeder extends Seeder
{
    public function run(): void
    {
        Law::factory()->count(5)->create();
        Annotation::factory()->count(5)->create();
        // Attach the tables (create the realtionship)
        law::all()->each(function ($law) {
            $annotation = Annotation::inRandomOrder()->first();
            $law->annotations()->attach(
                $annotation,
                ['cursorIndex' => rand(1, 100)]
            );
        });
    }
}
