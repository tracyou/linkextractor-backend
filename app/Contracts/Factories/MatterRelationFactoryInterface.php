<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\Matter;
use App\Models\MatterRelation;

interface MatterRelationFactoryInterface
{
    public function create(Matter $matterA, Matter $matterB, string $relation, string $description): MatterRelation;

}
