<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Contracts\Factories\MatterRelationFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Contracts\Factories\RelationSchemaFactoryInterface;
use App\Contracts\Repositories\MatterRelationSchemaRepositoryInterface;
use App\Contracts\Repositories\MatterRepositoryInterface;
use App\Contracts\Repositories\RelationSchemaRepositoryInterface;
use App\Models\Matter;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Illuminate\Support\Collection;
use stdClass;

final class SaveMatterRelationSchema
{
    public function __construct(
        protected MatterRepositoryInterface $matterRepository,
        protected RelationSchemaRepositoryInterface $relationSchemaRepository,
        protected MatterRelationSchemaRepositoryInterface $matterRelationSchemaRepository,

        protected MatterRelationFactoryInterface $matterRelationFactory,
        protected RelationSchemaFactoryInterface $relationSchemaFactory,
        protected MatterRelationSchemaFactoryInterface $matterRelationSchemaFactory,
    ) {
    }

    /**
     * @param                      $_
     * @param array<string, mixed> $args
     *
     * @return MatterRelationSchema
     */
    public function __invoke($_, array $args): MatterRelationSchema
    {
        $matterId = $args['matter_id'];
        $relationSchemaId = $args['relation_schema_id'] ?? null;
        $matterRelationSchemaId = $args['matter_relation_schema_id'] ?? null;
        $relations = collect($args['relations']);
        $schemaLayout = $args['schema_layout'];

        $matter = $this->matterRepository->findOrFail($matterId);

        $relationSchema = $this->getOrCreateRelationSchema($relationSchemaId);

        $matterRelationSchema = $this->getOrCreateMatterRelationSchema(
            matterRelationSchemaId: $matterRelationSchemaId,
            matter                : $matter,
            relationSchema        : $relationSchema,
            schemaLayout          : $schemaLayout,
        );

        $matterRelationSchema = $this->assignRelationsToMatterSchema(
            matterRelationSchema: $matterRelationSchema,
            relations           : $relations,
        );

        return $this->assignRelationsToMatterSchema(
            matterRelationSchema: $matterRelationSchema,
            relations           : $relations
        );
    }

    /**
     * It will create a new relation schema if the id is null or the relation schema is already published, since we
     * don't want to update a published schema.
     *
     * @param string|null $relationSchemaId
     *
     * @return RelationSchema
     */
    protected function getOrCreateRelationSchema(string $relationSchemaId = null): RelationSchema
    {
        if ($relationSchemaId === null || $this->relationSchemaRepository->findOrFail($relationSchemaId)->is_published) {
            return $this->relationSchemaFactory->create(
                isPublished: false,
            );
        }

        return $this->relationSchemaRepository->findOrFail($relationSchemaId);
    }

    /**
     * It will create a new matter relation schema if the id is null or the relation schema is already published, since
     * we don't want to update a published schema.
     *
     * @param string|null    $matterRelationSchemaId
     * @param Matter         $matter
     * @param RelationSchema $relationSchema
     * @param string         $schemaLayout
     *
     * @return MatterRelationSchema
     */
    protected function getOrCreateMatterRelationSchema(
        ?string $matterRelationSchemaId,
        Matter $matter,
        RelationSchema $relationSchema,
        string $schemaLayout,
    ): MatterRelationSchema {
        if ($matterRelationSchemaId === null || $this->matterRelationSchemaRepository->findOrFail($matterRelationSchemaId)->relationSchema->is_published) {
            return $this->matterRelationSchemaFactory->create(
                matter        : $matter,
                relationSchema: $relationSchema,
                schemaLayout  : $schemaLayout,
            );
        }

        $matterRelationSchema = $this->matterRelationSchemaRepository->findOrFail($matterRelationSchemaId);
        $matterRelationSchema->schema_layout = $schemaLayout;
        $matterRelationSchema->save();

        return $matterRelationSchema;
    }

    /**
     * It will delete all the existing relations on this matter relation schema and create new ones. The deletion only
     * happens if the matter relation schema is not published, so we are allowed to alter it.
     *
     * @param MatterRelationSchema      $matterRelationSchema
     * @param Collection<string, mixed> $relations
     *
     * @return MatterRelationSchema
     */
    protected function assignRelationsToMatterSchema(
        MatterRelationSchema $matterRelationSchema,
        Collection $relations,
    ): MatterRelationSchema {
        $matterRelationSchema->relations()->delete();

        $relations->each(function (array $relation) use ($matterRelationSchema): void {
            $this->matterRelationFactory->create(
                relatedMatter: $this->matterRepository->findOrFail($relation['related_matter_id']),
                schema       : $matterRelationSchema,
                relation     : $relation['relation'],
                description  : $relation['description'],
            );
        });

        $matterRelationSchema->refresh();

        return $matterRelationSchema;
    }
}
