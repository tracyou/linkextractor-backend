<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\RelationSchema;
use Illuminate\Database\Seeder;

class RelationSchemaSeeder extends Seeder
{
    public function run(): void
    {
        RelationSchema::factory()->count(1)->create();
    }
}
