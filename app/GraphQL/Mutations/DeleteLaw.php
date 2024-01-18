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

    /**
     * @param mixed[] $args
     *
     * @throws Error
     */
    public function __invoke(null $_, array $args): bool
    {
        $id = $args['input'];

        $law = $this->lawRepository->findOrFail($id);
       return $law->delete();

//        return $this->deleteLaw($id);
    }

//    /** @throws Error */
//    private function deleteLaw(?Model $id): bool
//    {
//        if ($law) {
//
//            $law->delete();
//
//            return true;
//        } else {
//            throw new Error('This id is incorrect');
//        }
//    }


}
