<?php

namespace Database\Seeders;

use App\Models\FileXml;
use Illuminate\Database\Seeder;

class FileXmlSeeder extends Seeder
{
    public function run(): void
    {
        FileXml::factory()->count(5)->create();
    }
}
