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
use App\Models\MatterRelation;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Illuminate\Support\Collection;

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
     * @param array<string, mixed> $args
     */
    public function __invoke($_, array $args): MatterRelationSchema
    {
        $matterId = $args['matter_id'];
        $relationSchemaId = $args['relation_schema_id'] ?? null;
        $relations = collect($args['relations']);
        $schemaLayout = $args['schema_layout'];

        $matter = $this->matterRepository->findOrFail($matterId);

        $relationSchema = $this->getOrCreateRelationSchema($relationSchemaId);

        $matterRelationSchema = $this->getOrCreateMatterRelationSchema(
            matter                : $matter,
            relationSchema        : $relationSchema,
            schemaLayout          : $schemaLayout,
        );

        return $this->assignRelationsToMatterSchema(
            matterRelationSchema: $matterRelationSchema,
            relations           : $relations
        );
    }

    /**
     * It will create a new relation schema if the id is null or the relation schema is already published, since we
     * don't want to update a published schema.
     */
    protected function getOrCreateRelationSchema(?string $relationSchemaId): RelationSchema
    {
        if ($relationSchemaId === null) {
            return $this->relationSchemaFactory->create(
                isPublished: false,
            );
        }

        $oldRelationSchema = $this->relationSchemaRepository->findOrFail($relationSchemaId);

        if ($oldRelationSchema->is_published) {
            $newRelationSchema = $this->relationSchemaFactory->create(
                isPublished: false,
            );

            $oldRelationSchema->matterRelationSchemas->each(function (MatterRelationSchema $oldMatterRelationSchema) use ($newRelationSchema): void {
                $newMatterRelationSchema = $this->matterRelationSchemaFactory->create(
                    matter        : $oldMatterRelationSchema->matter,
                    relationSchema: $newRelationSchema,
                    schemaLayout  : $oldMatterRelationSchema->schema_layout,
                );

                $oldMatterRelationSchema->relations->each(function (MatterRelation $oldRelation) use (
                    $newMatterRelationSchema,
                    $newRelationSchema,
                ): void {
                    $this->matterRelationFactory->create(
                        relatedMatter: $oldRelation->relatedMatter,
                        schema       : $newMatterRelationSchema,
                        relation     : $oldRelation->relation,
                        description  : $oldRelation->description,
                    );
                });
            });

            $newRelationSchema->refresh();

            return $newRelationSchema;
        }

        return $oldRelationSchema;
    }

    /**
     * It will create a new matter relation schema if the id is null or the relation schema is already published, since
     * we don't want to update a published schema.
     */
    protected function getOrCreateMatterRelationSchema(
        Matter $matter,
        RelationSchema $relationSchema,
        string $schemaLayout,
    ): MatterRelationSchema {
        $matterRelationSchema = $this->matterRelationSchemaRepository->getMatterRelationSchema(
            relationSchemaId: $relationSchema->getKey(),
            matterId        : $matter->getKey(),
        );

        if (!$matterRelationSchema) {
            return $this->matterRelationSchemaFactory->create(
                matter        : $matter,
                relationSchema: $relationSchema,
                schemaLayout  : $schemaLayout,
            );
        }

        $matterRelationSchema->schema_layout = $schemaLayout;
        $matterRelationSchema->save();

        return $matterRelationSchema;
    }

    /**
     * It will delete all the existing relations on this matter relation schema and create new ones. The deletion only
     * happens if the matter relation schema is not published, so we are allowed to alter it.
     *
     * @param Collection<string, mixed> $relations
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
                description  : $relation['description'] ?? null,
            );
        });

        $matterRelationSchema->refresh();

        return $matterRelationSchema;
    }
}
