<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Enums\MatterRelationEnum;
use App\Models\Matter;
use App\Models\MatterRelation;
use App\Models\MatterRelationSchema;

interface MatterRelationFactoryInterface
{
    public function create(
        Matter $relatedMatter,
        MatterRelationSchema $schema,
        MatterRelationEnum $relation,
        ?string $description,
    ): MatterRelation;
}
