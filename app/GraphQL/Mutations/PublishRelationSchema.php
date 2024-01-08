<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Contracts\Repositories\RelationSchemaRepositoryInterface;
use App\Models\RelationSchema;
use GraphQL\Error\Error;
use Illuminate\Database\ConnectionInterface;
use Throwable;

final class PublishRelationSchema
{
    public function __construct(
        protected ConnectionInterface $database,
        protected RelationSchemaRepositoryInterface $relationSchemaRepository,
    ) {
    }

    /**
     * @param array<string, mixed> $args
     *
     * @throws Error
     */
    public function __invoke($_, array $args): RelationSchema
    {
        $id = $args['id'];

        $schema = $this->relationSchemaRepository->findOrFail($id);

        if ($schema->is_published) {
            throw new Error('The schema is already published.');
        }

        /**
         * Use a transaction to ensure that only one schema is published at a time and in case of failure, there are
         * never none or multiple active schemas.
         */
        try {
            $this->database->transaction(function () use ($schema) {
                $schema->is_published = true;
                $schema->save();

                $this->relationSchemaRepository->expireAllExcept($schema->getKey());
            });
        } catch (Throwable $e) {
            throw new Error($e->getMessage(), previous: $e);
        }

        return $schema;
    }
}
