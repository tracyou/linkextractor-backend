<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\MatterRelationFactoryInterface;
use App\Enums\MatterRelationEnum;
use App\Models\Matter;
use App\Models\MatterRelation;
use App\Models\MatterRelationSchema;

final class MatterRelationFactory implements MatterRelationFactoryInterface
{
    public function create(
        Matter $relatedMatter,
        MatterRelationSchema $schema,
        MatterRelationEnum $relation,
        ?string $description
    ): MatterRelation
    {
        $matterRelation = new MatterRelation([
            'relation'    => $relation,
            'description' => $description,
        ]);

        $matterRelation->relatedMatter()->associate($relatedMatter);
        $matterRelation->matterRelationSchema()->associate($schema);

        $matterRelation->save();

        return $matterRelation;
    }
}
