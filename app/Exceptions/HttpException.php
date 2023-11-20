<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException as BaseHttpException;
use Throwable;

class HttpException extends BaseHttpException
{
    /**
     * @param int            $statusCode
     * @param string|null    $message
     * @param Throwable|null $previous
     * @param array          $headers
     * @param int|null       $code
     */
    public function __construct(
        int $statusCode,
        ?string $message = '',
        Throwable $previous = null,
        array $headers = [],
        ?int $code = null
    ) {
        parent::__construct($statusCode, $message, $previous, $headers, $code ?? $statusCode);
    }
}
