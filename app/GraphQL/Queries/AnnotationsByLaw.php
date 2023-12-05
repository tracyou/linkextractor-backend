<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\LawRepositoryInterface;
use App\Models\Annotation;
use App\Models\Law;
use Illuminate\Support\Collection;

class AnnotationsByLaw
{
    public function __construct(
        protected LawRepositoryInterface $lawRepository,
    ) {
    }

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Collection<int, Annotation>
     */
    public function __invoke(null $_, array $args): Collection
    {
        $id = $args['law_id'];

        /** @var Law $law */
        $law = $this->lawRepository->findOrFail($id);

        return $law->annotations()->get();
    }
}
