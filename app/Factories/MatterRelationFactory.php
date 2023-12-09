<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\MatterRelationFactoryInterface;
use App\Models\Matter;
use App\Models\MatterRelation;

final class MatterRelationFactory implements MatterRelationFactoryInterface
{
    public function create(Matter $matterA, Matter $matterB, string $relation, string $description): MatterRelation
    {
        $matterRelation = new MatterRelation([
            'relation'    => $relation,
            'description' => $description,
        ]);

        $matterRelation->matterParent()->associate($matterA);
        $matterRelation->matterChild()->associate($matterB);

        $matterRelation->save();

        return $matterRelation;
    }
}
