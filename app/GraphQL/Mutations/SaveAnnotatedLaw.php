<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Factories\AnnotationFactoryInterface;
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
        protected LawRepositoryInterface            $lawRepository,
        protected AnnotationRepositoryInterface     $annotationRepository,
        protected MatterRepositoryInterface         $matterRepository,
        protected AnnotationFactoryInterface        $annotationFactory,
        protected ArticleRepositoryInterface        $articleRepository,
        protected MatterRelationRepositoryInterface $matterRelationRepository,
        protected RelationSchemaRepositoryInterface $relationSchemaRepository,

    )
    {
    }

    public function __invoke($_, array $args): Law
    {
        $lawId = $args['lawId'];
        $isPublished = $args['isPublished'];
        $articles = collect($args['articles']);

        /** @var Law $law */
        $law = $this->lawRepository->findOrFail($lawId);

        $law->is_published = $isPublished;

        $newRevisionNumber = $this->annotationRepository->getNewRevisionNumber($law);

        $articles->each(function (array $articleInput) use ($newRevisionNumber) {
            $annotationMappings = new Collection();

            /** @var Article $article */
            $article = $this->articleRepository->findOrFail($articleInput['articleId']);

            $articleAnnotationMapping = collect($articleInput['annotations'])->map(function ($annotationInput) use ($article, $newRevisionNumber) {
                $matter = $this->matterRepository->findOrFail($annotationInput['matterId']);
                $comment = $annotationInput['comment'];
                $definition = $annotationInput['definition'];
                $text = $annotationInput['text'];
                $tempId = $annotationInput['tempId'];
                $relationSchema = $this->relationSchemaRepository->getMostRecent();

                $annotation = $this->annotationFactory->create(
                    $matter,
                    $text,
                    $definition,
                    $comment,
                    $newRevisionNumber,
                    $article,
                    $relationSchema
                );

                return [
                    'tempId' => $tempId,
                    'newId' => $annotation->getKey(),
                ];
            });

            $jsonText = json_encode($articleInput['json_text']);

            $articleAnnotationMapping->each(function ($mapping) use (&$jsonText) {
                $jsonText = str_replace($mapping['tempId'], $mapping['newId'], $jsonText);
            });

            $article->json_text = $jsonText;
            $article->save();

            $annotationMappings->merge($articleAnnotationMapping);
        });

        $law->save();

        return $law;
    }


}
