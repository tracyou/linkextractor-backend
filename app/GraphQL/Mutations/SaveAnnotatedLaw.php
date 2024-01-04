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
use App\Models\Law;


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

    public function __invoke($_, array $args): Law|null
    {
        $lawId = $args['lawId'];
        $lawTitle = $args['title'];
        $isPublished = $args['isPublished'];
        $articles = collect($args['articles']);


        /** @var Law $law */
        $law = $this->lawRepository->findOrFail($lawId);

        $law->is_published = $isPublished;
        $law->title = $lawTitle;

        $articles->each(function (array $articleInput) {
            $article = $this->articleRepository->findOrFail($articleInput['articleId']);
            $annotations = collect($articleInput['annotations'])->each(function ($annotationInput) use ($article) {
                $matter = $this->matterRepository->findOrFail($annotationInput['matterId']);
                $comment = $annotationInput['comment'];
                $cursorIndex = $annotationInput['cursorIndex'];
                $text = $annotationInput['text'];
                $relationSchema = $this->relationSchemaRepository->findOrFail($annotationInput['relationSchemaId']);

                return $this->annotationFactory->create(
                    $matter,
                    $text,
                    $cursorIndex,
                    $comment,
                    $article,
                    $relationSchema
                );
            });

        });

        $law->save();
        return $law;
    }


}
