<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleRevisionFactoryInterface;
use App\Contracts\Repositories\AnnotationRepositoryInterface;
use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Contracts\Repositories\LawRepositoryInterface;
use App\Contracts\Repositories\MatterRelationRepositoryInterface;
use App\Contracts\Repositories\MatterRelationSchemaRepositoryInterface;
use App\Contracts\Repositories\MatterRepositoryInterface;
use App\Contracts\Repositories\RelationSchemaRepositoryInterface;
use App\Models\Article;
use App\Models\Law;
use Illuminate\Support\Collection;

class SaveAnnotatedLaw
{
    public function __construct(
        protected LawRepositoryInterface $lawRepository,
        protected MatterRepositoryInterface $matterRepository,
        protected ArticleRepositoryInterface $articleRepository,
        protected MatterRelationRepositoryInterface $matterRelationRepository,
        protected RelationSchemaRepositoryInterface $relationSchemaRepository,
        protected AnnotationFactoryInterface $annotationFactory,
        protected ArticleRevisionFactoryInterface $articleRevisionFactory,
    ) {
    }

    public function __invoke($_, array $args): Law
    {
        $lawId = $args['law_id'];
        $isPublished = $args['is_published'] ?? null;
        $articles = collect($args['articles']);

        /** @var Law $law */
        $law = $this->lawRepository->findOrFail($lawId);
        $law->is_published = $isPublished ?? $law->is_published;

        $articles->each(function (array $articleInput) {
            /** @var Article $article */
            $article = $this->articleRepository->findOrFail($articleInput['article_id']);

            $articleRevision = $this->articleRevisionFactory->create($article, null);

            $articleAnnotationMapping = collect($articleInput['annotations'])->map(function ($annotationInput) use (
                $article,
                $articleRevision,
            ) {
                $matter = $this->matterRepository->findOrFail($annotationInput['matter_id']);
                $comment = $annotationInput['comment'];
                $definition = $annotationInput['definition'];
                $text = $annotationInput['text'];
                $tempId = $annotationInput['temp_id'];
                $relationSchema = $this->relationSchemaRepository->getMostRecent();

                $annotation = $this->annotationFactory->create(
                    matter         : $matter,
                    text           : $text,
                    definition     : $definition,
                    comment        : $comment,
                    articleRevision: $articleRevision,
                    schema         : $relationSchema
                );

                return [
                    'tempId' => $tempId,
                    'newId'  => $annotation->getKey(),
                ];
            });

            $jsonText = $articleInput['json_text'];
            $articleAnnotationMapping->each(function ($mapping) use (&$jsonText) {
                $jsonText = str_replace($mapping['tempId'], $mapping['newId'], $jsonText);
            });

            $articleRevision->json_text = $jsonText;

            $articleRevision->save();
        });

        $law->revision += 1;
        $law->save();

        return $law;
    }
}
