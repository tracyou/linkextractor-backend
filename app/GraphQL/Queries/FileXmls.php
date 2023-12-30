<?php declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\FileXmlRepositoryInterface;
use App\Models\FileXml;
use Illuminate\Database\Eloquent\Collection;

class FileXmls
{
    public function __construct(
        protected FileXmlRepositoryInterface $fileXmlRepository,
    ) {
    }

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Collection<int, FileXml>
     */
    public function __invoke(null $_, array $args): Collection
    {
        return $this->fileXmlRepository->all();
    }

}

