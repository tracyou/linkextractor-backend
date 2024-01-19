<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use GraphQL\Error\Error;

class SchemaValidationException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
