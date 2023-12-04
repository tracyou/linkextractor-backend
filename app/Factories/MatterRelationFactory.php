<?php

namespace App\Factories;

use App\Models\Matter;
use App\Models\MatterRelation;

class MatterRelationFactory
{
    public function create(Matter $matterA, Matter $matterB, string $relation, string $description): MatterRelation
    {
        $matterRelation = new MatterRelation([
            'relation' => $relation,
            'description' => $description
        ]);

        $matterRelation->matterA()->associate($matterA);
        $matterRelation->matterB()->associate($matterB);

        $matterRelation->save();

        return $matterRelation;
    }
}
