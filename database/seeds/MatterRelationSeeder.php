<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MatterRelationEnum;
use App\Models\Matter;
use App\Models\MatterRelation;
use Illuminate\Database\Seeder;

class MatterRelationSeeder extends Seeder
{
    public const DESCRIPTIONS = [
        'heeft recht op',
        'heeft als voorwerp',
        'wordt gewijzigd door',
        'wordt gecreeërd door',
    ];

    /** Run the database seeds. */
    public function run(): void
    {
        $matters = Matter::inRandomOrder()->limit(3)->get();

        $matters->each(function (Matter $matter) use ($matters): void {
            $matters->each(function (Matter $otherMatter) use ($matter): void {
                if ($matter->id !== $otherMatter->id) {
                    MatterRelation::factory()->create([
                        'matter_parent_id' => $matter->id,
                        'matter_child_id'  => $otherMatter->id,
                        'relation'         => MatterRelationEnum::getRandomValue(),
                        'description'      => self::DESCRIPTIONS[array_rand(self::DESCRIPTIONS)],
                    ]);
                }
            });
        });
    }
}
