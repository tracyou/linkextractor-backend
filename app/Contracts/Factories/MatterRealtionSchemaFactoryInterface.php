<?php

namespace App\Contracts\Factories;

use App\Models\MatterRelationSchema;
use DateTime;

interface MatterRealtionSchemaFactoryInterface
{
    public function create(
        DateTime $expiredAt
    ): MatterRelationSchema;
}
