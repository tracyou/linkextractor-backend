<?php

declare(strict_types=1);

namespace App\Helpers\RelationSchema;

use App\Contracts\Repositories\MatterRelationSchemaRepositoryInterface;
use App\Enums\MatterRelationEnum;
use App\Models\Matter;
use App\Models\MatterRelation;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use App\Structs\AnnotationStruct;
use GraphQL\Error\Error;
use Illuminate\Support\Collection;

class SchemaValidator implements SchemaValidatorInterface
{
    public function __construct(
        protected MatterRelationSchemaRepositoryInterface $matterRelationSchemaRepository,
    ) {
    }

    /**
     * @param RelationSchema                    $schema
     * @param Collection<int, AnnotationStruct> $annotations
     *
     * @throws Error
     */
    public function validate(RelationSchema $schema, Collection $annotations): void
    {
        $matterRelationSchemas = $this->matterRelationSchemaRepository->getForRelationSchema($schema->getKey());
        $annotations->each(function (AnnotationStruct $annotation) use (
            $matterRelationSchemas,
            $annotations,
        ) {
            /** @var MatterRelationSchema|null $matterRelationSchema */
            $matterRelationSchema = $matterRelationSchemas->first(function (
                MatterRelationSchema $matterRelationSchema) use ($annotation) {
                return $matterRelationSchema->matter_id === $annotation->matter->getKey();
            });

            $matterRelationSchema?->relations()->each(function (MatterRelation $relation) use (
                $annotation,
                $annotations,
            ) {
                if (! $this->meetsRelation(
                    annotations  : $annotations,
                    annotationId : $annotation->tempId,
                    relatedMatter: $relation->relatedMatter,
                    relation     : $relation->relation,
                )) {
                    throw new Error("Voorwaarde in het relatieschema: \"{$annotation->matter->name} " . strtolower($relation->relation->value) . " {$relation->relatedMatter->name}\" wordt niet vervuld in artikel: \"{$annotation->article->title}\"");
                }
            });
        });
    }

    /**
     * @param Collection<int, AnnotationStruct> $annotations
     * @param string                            $annotationId
     * @param Matter                            $relatedMatter
     * @param MatterRelationEnum                $relation
     *
     * @return bool
     */
    protected function meetsRelation(
        Collection $annotations,
        string $annotationId,
        Matter $relatedMatter,
        MatterRelationEnum $relation
    ): bool {
        return match ($relation->value) {
            MatterRelationEnum::REQUIRES_ONE, MatterRelationEnum::REQUIRES_ONE_OR_MORE          => $this->isMatterPresent($annotations, $annotationId, $relatedMatter),
            MatterRelationEnum::REQUIRES_ZERO_OR_MORE, MatterRelationEnum::REQUIRES_ZERO_OR_ONE => true,
        };
    }

    /**
     * @param Collection<int, AnnotationStruct> $annotations
     * @param string                            $annotationId
     * @param Matter                            $matter
     * @return bool
     */
    protected function isMatterPresent(Collection $annotations, string $annotationId, Matter $matter): bool
    {
        return $annotations->contains(function (AnnotationStruct $annotation) use ($annotationId, $matter) {
            return $annotation->matter->getKey() === $matter->getKey() && $annotation->tempId !== $annotationId;
        });
    }
}
