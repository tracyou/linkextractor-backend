<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Repositories\LawRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

final class DeleteLaw
{

    public function __construct(
        protected LawRepositoryInterface $lawRepository,
    ) {
    }

    public function __invoke($_, array $args): bool
    {
        $id = $args['id'];

        $law = $this->lawRepository->find($id);

        return $this->deleteLaw($law);
    }

    private function deleteLaw(?Model $law): bool
    {
        if ($law) {

            $law->update(['deleted_at' => Carbon::now()]);

            return true;
        } else {
            return false;
        }
    }


}
