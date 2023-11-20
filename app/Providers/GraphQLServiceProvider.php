<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MLL\GraphQLScalars\JSON;
use Nuwave\Lighthouse\Exceptions\DefinitionException;
use Nuwave\Lighthouse\Schema\TypeRegistry;
use Nuwave\Lighthouse\Schema\Types\LaravelEnumType;
use Nuwave\Lighthouse\Schema\Types\Scalars\Date;
use Nuwave\Lighthouse\Schema\Types\Scalars\DateTime;

class GraphQLServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    protected array $scalars = [
        JSON::class,
    ];

    /**
     * @var string[]
     */
    protected array $types = [
        Date::class,
        DateTime::class,
    ];

    /**
     * @var string[]
     */
    protected array $enums = [
    ];

    /**
     * @throws DefinitionException
     */
    public function boot(TypeRegistry $typeRegistry): void
    {
        foreach ($this->scalars as $scalar) {
            $typeRegistry->overwrite(
                new $scalar(),
            );
        }

        foreach ($this->types as $type) {
            $typeRegistry->register(
                new $type(),
            );
        }

        foreach ($this->enums as $enum) {
            $typeRegistry->register(
                new LaravelEnumType($enum),
            );
        }
    }
}
