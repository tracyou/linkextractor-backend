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
        $matters = Matter::inRandomOrder()->limit(6)->get();
        foreach ($matters as $matter) {
            $schemaLayout = '
                {
                    "nodes": [
                        {
                            "width":150,
                            "height":40,
                            "id":"1",
                            "style": {
                                "backgroundColor":"' . $matter->color . '",
                                "color":"#000000",
                                "border":"1px solid #ABABAB"
                            },
                            "type":"input",
                            "data": {
                                "label":"' . $matter->name . '",
                                "matterId":"' . $matter->id . '"
                            },
                            "position": {
                                "x":0,
                                "y":0
                            },
                            "positionAbsolute": {
                                "x":0,
                                "y":0
                            }
                        }
                    ],
                    "edges": [],
                    "viewport": {
                        "x": 148,
                        "y": 266.5,
                        "zoom": 2
                    }
                }
            ';

            MatterRelationSchema::factory()->count(1)->create([
                'matter_id'          => $matter->getKey(),
                'relation_schema_id' => RelationSchema::first()->getKey(),
                'schema_layout'      => $schemaLayout,
            ]);
        }
    }
}
