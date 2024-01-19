<?php

declare(strict_types=1);

namespace App\GraphQL\Scalars;

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;
use Str;

/**
 * @codeCoverageIgnore
 */
final class UUID extends ScalarType
{
    /**
     * Serializes an internal value to include in a response.
     *
     * @param mixed $value
     */
    public function serialize($value): mixed
    {
        if (!Str::isUuid($value)) {
            throw new InvariantViolation("Could not serialize following value as UUID: " . Utils::printSafe($value));
        }

        return $value;
    }

    /**
     * Parses an externally provided value (query variable) to use as an input.
     *
     * @param mixed $value
     */
    public function parseValue($value): mixed
    {
        if (!Str::isUuid($value)) {
            throw new InvariantViolation("Cannot represent following value as UUID: " . Utils::printSafe($value));
        }

        return $value;
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * @param array<string, mixed>|null $variables
     *
     * @throws Error
     */
    public function parseLiteral(Node $valueNode, ?array $variables = null): mixed
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, [$valueNode]);
        }

        if (!Str::isUuid($valueNode->value)) {
            throw new Error("Not a valid UUID", [$valueNode]);
        }

        return $valueNode->value;
    }
}
