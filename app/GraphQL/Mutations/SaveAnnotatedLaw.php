<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Repositories\AnnotationRepositoryInterface;
use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Contracts\Repositories\LawRepositoryInterface;
use App\Contracts\Repositories\MatterRelationRepositoryInterface;
use App\Contracts\Repositories\MatterRepositoryInterface;
use App\Models\Law;
use Database\Factories\AnnotationFactory;
use function Laravel\Prompts\text;

class SaveAnnotatedLaw
{

    public function __construct(
        protected LawRepositoryInterface        $lawRepository,
        protected AnnotationRepositoryInterface $annotationRepository,
        protected MatterRepositoryInterface     $matterRepository,
        protected AnnotationFactoryInterface $annotationFactory,
        protected ArticleRepositoryInterface $articleRepository,
        protected MatterRelationRepositoryInterface $matterRelationRepository,

    )
    {
    }

    public function __invoke($_, array $args): Law|null
    {
        $lawId = $args['lawId'];
        $lawTitle = $args['title'];
        $isPublished = $args['isPublished'];
        $articles = collect($args['articles']);
        $annotations = collect($args['annotations']);



        /** @var Law $law */
        $law = $this->lawRepository->findOrFail($lawId);

        $law->is_published = $isPublished;
        $law->title = $lawTitle;

        $articles->each(function (array $articleInput) use ($annotations) {
            $article = $this->articleRepository->findOrFail('articleId');
            $annotations->each(function (array $annotationInput) use ($article) {
                $matter = $this->matterRepository->findOrFail($annotationInput['matterId']);
                $comment = $this->annotationRepository->findOrFail($annotationInput['comment']);
                $cursorIndex = $this->annotationRepository->findOrFail($annotationInput['cursorIndex']);
                $text = $this->articleRepository->findOrFail('text');
                $matterRelationSchema = $this->matterRelationRepository->findOrFail('matterRelationSchemaId');

                $annotation = $this->annotationFactory->create(
                    $matter,
                    $text,
                    $comment,
                    $cursorIndex,
                    $article,
                    $matterRelationSchema

                );
            });

        });


        $law->refresh();

        $law->save();
        return $law;
    }


}
