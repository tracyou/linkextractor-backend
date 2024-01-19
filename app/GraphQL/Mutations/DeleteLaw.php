<?php

declare(strict_types=1);

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

    /**
     * @param mixed[] $args
     *
     * @throws Error
     */
    public function __invoke(null $_, array $args): bool
    {
        $id = $args['input'];

        $law = $this->lawRepository->find($id);

        return $this->deleteLaw($law);
    }

    /** @throws Error */
    private function deleteLaw(?Model $law): bool
    {
        if ($law) {
            $law->delete();
            $law->update(array('is_published' => false));

            return true;
        } else {
            throw new Error('This id is incorrect');
        }
    }
}
