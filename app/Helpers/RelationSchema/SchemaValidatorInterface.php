<?php

declare(strict_types=1);

namespace App\Helpers\RelationSchema;

use App\Models\RelationSchema;
use Illuminate\Support\Collection;

interface SchemaValidatorInterface
{
    public function validate(RelationSchema $schema, Collection $annotations): void;
}
