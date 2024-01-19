<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleRevisionFactoryInterface;
use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Contracts\Repositories\ArticleRevisionRepositoryInterface;
use App\Contracts\Repositories\LawRepositoryInterface;
use App\Contracts\Repositories\MatterRelationRepositoryInterface;
use App\Contracts\Repositories\MatterRepositoryInterface;
use App\Contracts\Repositories\RelationSchemaRepositoryInterface;
use App\Helpers\RelationSchema\SchemaValidatorInterface;
use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\Law;
use App\Models\RelationSchema;
use App\Structs\AnnotationStruct;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Collection;
use Throwable;

class SaveAnnotatedLaw
{
    public function __construct(
        protected readonly ConnectionInterface $database,

        protected LawRepositoryInterface $lawRepository,
        protected MatterRepositoryInterface $matterRepository,
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleRevisionRepositoryInterface $articleRevisionRepository,
        protected MatterRelationRepositoryInterface $matterRelationRepository,
        protected RelationSchemaRepositoryInterface $relationSchemaRepository,
        protected AnnotationFactoryInterface $annotationFactory,
        protected ArticleRevisionFactoryInterface $articleRevisionFactory,
        protected SchemaValidatorInterface $schemaValidator,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function __invoke($_, array $args): Law
    {
        $lawId = $args['law_id'];
        $isPublished = $args['is_published'] ?? null;
        $articles = collect($args['articles']);

        /** @var Law $law */
        $law = $this->lawRepository->findOrFail($lawId);

        // Begin database transaction
        $this->database->transaction(function () use ($law, $isPublished, $articles) {

            $law->is_published = $isPublished ?? $law->is_published;

            $articles->each(function (array $articleInput) {
                /** @var Article $article */
                $article = $this->articleRepository->findOrFail($articleInput['article_id']);
                $annotations = collect($articleInput['annotations']);

                // If the article has no annotations, and also hasn't been annotated before, we can skip it.
                if ($annotations->isEmpty() && $article->revisions->isEmpty()) {
                    return;
                }

                // Create a new article revision
                $articleRevision = $this->articleRevisionFactory->create($article);

                // Get the most recent (published) relation schema
                $relationSchema = $this->relationSchemaRepository->getMostRecent();

                // Map API inputs to a data object
                $annotations = $this->mapAnnotationsToStructs($annotations, $article);

                // Validate the annotations against the relation schema
                $this->schemaValidator->validate($relationSchema, $annotations);

                // Insert annotations into the database and return a mapping of tempId => newId
                $articleAnnotationMapping = $this->createAndMapAnnotations(
                    annotations    : $annotations,
                    articleRevision: $articleRevision,
                    relationSchema : $relationSchema,
                );

                // Replace tempIds in the json_text with the newIds and save it in the article revision
                $articleRevision->json_text = $this->formatJsonText(
                    jsonText                : $articleInput['json_text'],
                    articleAnnotationMapping: $articleAnnotationMapping
                );

                $articleRevision->save();
            });

            $law->revision += 1;
            $law->save();

        });

        $law->articles->map(function (Article $article) use ($law) {
            $article->revision = $this->articleRevisionRepository->getArticleRevision($article, $law->revision);
        });

        return $law;
    }

    /**
     * @param Collection<string, mixed> $annotations
     * @param Article                   $article
     *
     * @return Collection<int, AnnotationStruct>
     */
    protected function mapAnnotationsToStructs(Collection $annotations, Article $article): Collection
    {
        return $annotations->map(function ($annotationInput) use ($article) {
            $tempId = $annotationInput['temp_id'];
            $matter = $this->matterRepository->findOrFail($annotationInput['matter_id']);

            return new AnnotationStruct(
                tempId    : $tempId,
                matter    : $matter,
                text      : $annotationInput['text'],
                definition: $annotationInput['definition'],
                comment   : $annotationInput['comment'],
                article   : $article,
            );
        });
    }

    /**
     * @param Collection<int, AnnotationStruct> $annotations
     * @param ArticleRevision                   $articleRevision
     * @param RelationSchema                    $relationSchema
     *
     * @return Collection
     */
    protected function createAndMapAnnotations(
        Collection $annotations,
        ArticleRevision $articleRevision,
        RelationSchema $relationSchema,
    ): Collection {
        return $annotations->map(function ($annotationStruct) use ($articleRevision, $relationSchema) {
            $annotation = $this->annotationFactory->create(
                matter         : $annotationStruct->matter,
                text           : $annotationStruct->text,
                definition     : $annotationStruct->definition,
                comment        : $annotationStruct->comment,
                articleRevision: $articleRevision,
                schema         : $relationSchema
            );

            return [
                'tempId' => $annotationStruct->tempId,
                'newId'  => $annotation->getKey(),
            ];
        });
    }

    /**
     * @param string                                 $jsonText
     * @param Collection<int, array<string, string>> $articleAnnotationMapping
     *
     * @return string
     */
    protected function formatJsonText(string $jsonText, Collection $articleAnnotationMapping): string
    {
        $articleAnnotationMapping->each(function ($mapping) use (&$jsonText) {
            $jsonText = str_replace($mapping['tempId'], $mapping['newId'], $jsonText);
        });

        return $jsonText;
    }
}
