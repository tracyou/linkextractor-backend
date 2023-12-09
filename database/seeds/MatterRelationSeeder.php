<?php

namespace Database\Seeders;

use App\Models\MatterRelation;
use Illuminate\Database\Seeder;

class MatterRelationSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        MatterRelation::factory()
            ->count(5)
            ->create();
    }
}
