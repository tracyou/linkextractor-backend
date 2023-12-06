<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class AbstractModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected $keyType = 'string';
}
