<?php

namespace App\GraphQL\Mutations;

use App\Helpers\Import\LawXmlImport;
use App\Models\Annotation;
use App\Models\Law;
use GraphQL\Error\Error;
use Illuminate\Support\Collection;
use Storage;

final class ImportXml
{
    public function __construct(
    ) {
    }

    /**
     * @param array<string, mixed> $args
     *
     * @throws Error
     *
     * @return Collection<int, Annotation>
     */
    public function __invoke(null $_, array $args): Law
    {
        $file = $args['file'];

        $tempFilePath = Storage::putFile('temp', $file);
        $xmlFilePath = storage_path('app/' . $tempFilePath);

        return (new LawXmlImport())->import($xmlFilePath);
    }
}
