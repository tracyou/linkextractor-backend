<?php

namespace Database\Seeders;

use App\Models\Matter;
use Illuminate\Database\Seeder;

class MatterSeeder extends Seeder
{
    public const MATTERS = [
        [
            'name'  => 'Rechtssubject',
            'color' => '#d7e9f9',
        ],
        [
            'name'  => 'Rechtsobject',
            'color' => '#b1c3e6',
        ],
        [
            'name'  => 'Rechtsfeit',
            'color' => '#bad8f4',
        ],
        [
            'name'  => 'Rechtsbetrekking',
            'color' => '#8fa1d3',
        ],
        [
            'name'  => 'Voorwaarde',
            'color' => '#b7d7cc',
        ],
        [
            'name'  => 'Operator',
            'color' => '#d5e7e2',
        ],
        [
            'name'  => 'Afleidingsregel',
            'color' => '#d47478',
        ],
        [
            'name'  => 'Variabele',
            'color' => '#f7da60',
        ],
        [
            'name'  => 'Variabele waarde',
            'color' => '#fbf184',
        ],
        [
            'name'  => 'Tijdsaanduiding',
            'color' => '#cdb9d9',
        ],
        [
            'name'  => 'Plaatsonaanduiding',
            'color' => '#e5d2e6',
        ],
        [
            'name'  => 'Parameter',
            'color' => '#e7b8bb',
        ],
        [
            'name'  => 'Parameterwaarde',
            'color' => '#f2deec',
        ],
        [
            'name'  => 'Delegatie bevoegdheid',
            'color' => '#d6d5d5',
        ],
        [
            'name'  => 'Delegatie invulling',
            'color' => '#e9e8e9',
        ],
    ];

    /** Run the database seeds. */
    public function run(): void
    {
        Matter::factory()->createMany(self::MATTERS);
    }
}
