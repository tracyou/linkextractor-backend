<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MatterRelationEnum;
use App\Models\Matter;
use App\Models\MatterRelation;
use App\Models\MatterRelationSchema;
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
            $matters->each(function (Matter $relatedMatter) use ($matter): void {
                $matterRelationSchema = MatterRelationSchema::where('matter_id', $matter->getKey())->first();
                if ($matterRelationSchema && $matter->getKey() !== $relatedMatter->getKey()) {
                    MatterRelation::factory()->create([
                        'related_matter_id'         => $relatedMatter->getKey(),
                        'relation'                  => MatterRelationEnum::getRandomValue(),
                        'description'               => self::DESCRIPTIONS[array_rand(self::DESCRIPTIONS)],
                        'matter_relation_schema_id' => $matterRelationSchema->getKey(),
                    ]);
                }
            });
        });
    }
}
