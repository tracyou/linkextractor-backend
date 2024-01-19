<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

/**
 * @codeCoverageIgnore
 */
class CheckForMaintenanceMode extends Middleware
{
    /** @inheritdoc */
    protected $except = [
        //
    ];
}
