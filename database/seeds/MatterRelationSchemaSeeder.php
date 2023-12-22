<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Matter;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Illuminate\Database\Seeder;

class MatterRelationSchemaSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Matter::all() as $matter) {
            MatterRelationSchema::factory()->count(1)->create([
                'matter_id' => $matter->getKey(),
                'relation_schema_id' => RelationSchema::first()->getKey(),
            ]);
        }
    }
}
