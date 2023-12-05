<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static REQUIRES_ONE()
 * @method static static REQUIRES_ZERO_OR_ONE()
 * @method static static REQUIRES_ONE_OR_MORE()
 * @method static static REQUIRES_ZERO_OR_MORE()
 */
final class MatterRelationEnum extends Enum
{
    public const REQUIRES_ONE = 'requires_one';
    public const REQUIRES_ZERO_OR_ONE = 'requires_zero_or_one';
    public const REQUIRES_ONE_OR_MORE = 'requires_one_or_more';
    public const REQUIRES_ZERO_OR_MORE = 'requires_zero_or_more';
}
