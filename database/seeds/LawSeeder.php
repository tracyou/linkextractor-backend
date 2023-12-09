<?php

namespace Database\Seeders;

use App\Models\Law;
use Illuminate\Database\Seeder;

class LawSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        Law::factory()->count(5)->create();
    }
}
