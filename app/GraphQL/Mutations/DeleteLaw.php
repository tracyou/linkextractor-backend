<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Repositories\LawRepositoryInterface;
use GraphQL\Error\Error;
use Illuminate\Database\Eloquent\Model;

final class DeleteLaw
{
    public function __construct(
        protected LawRepositoryInterface $lawRepository,
    ) {
    }

    public function __invoke(null $_, array $args): bool
    {
        $id = $args['id'];

        $law = $this->lawRepository->find($id);

        // Add comment  1
        // Add comment 2
        // Add comment 3

        return $law->delete();
    }
}
