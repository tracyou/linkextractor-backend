<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\LawRepositoryInterface;
use App\Models\Article;
use App\Models\Law;

class LawRevisions
{
    public function __construct(
        protected LawRepositoryInterface $lawRepository,
    ) {
    }

    public function __invoke(null $_, array $args): array
    {
        $lawId = $args['id'];

        /** @var Law $law */
        $law = $this->lawRepository->findOrFail($lawId);

        $revisions = [];

        // Loop over all revisions starting from 1 until $law->revision
        for ($revision = 1; $revision <= $law->revision; $revision++) {
            $law->articles->map(function (Article $article) use ($revision, &$revisions) {
                $articleRevision = $article->revisions->where('revision', $revision)->first();

                if (! $articleRevision) {
                    return;
                }

                $revisions[] = [
                    'revision'  => $revision,
                    'createdAt' => $articleRevision->created_at,
                ];
            });
        }

        $revisions = array_unique($revisions, SORT_REGULAR);

        return [
            'law' => $law,
            'revisions' => $revisions,
        ];
    }
}
