<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Repositories\LawRepositoryInterface;
use App\Contracts\Repositories\MatterRepositoryInterface;
use App\Models\Law;
use Database\Factories\AnnotationFactory;

class SaveAnnotatedLaw
{

    public function __construct(
        protected LawRepositoryInterface     $lawRepository,
        protected AnnotationFactoryInterface $annotationFactory,
        protected MatterRepositoryInterface  $matterRepository,

    )
    {
    }

    public function __invoke($_, array $args): Law|null
    {
        $lawId = $args['lawId'];
        $isPublished = $args['isPublished'];
        $annotations = collect($args['annotations']);


        /** @var Law $law */
        $law = $this->lawRepository->findOrFail($lawId);

        $law->is_published = $isPublished;


        $annotations->each(function (array $annotationInput) use ($law) {
            $matter = $this->matterRepository->findOrFail($annotationInput['matterId']);
            $annotation = $this->annotationFactory->create($matter, $annotationInput['text']);

            $law->annotations()->attach($annotation->id, [
                'cursor_index' => $annotationInput['cursorIndex'],
                'comment' => $annotationInput['comment'],
            ]);
        });

        $law->save();
        return $law;
    }


}
