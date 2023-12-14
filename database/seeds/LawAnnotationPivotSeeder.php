<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Annotation;
use App\Models\Law;
use Illuminate\Database\Seeder;

class LawAnnotationPivotSeeder extends Seeder
{
    public function run(): void
    {
        Annotation::factory()->count(5)->create();

        Law::all()->each(function ($law) {
            $annotation = Annotation::inRandomOrder()->first();
            $law->annotations()->attach($annotation, [
                'cursor_index' => rand(1, 100),
                'comment'      => 'This is a comment',
            ]);
        });
    }
}
