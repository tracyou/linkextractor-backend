<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Helpers\Import\LawXmlImport;
use App\Models\Law;
use GraphQL\Error\Error;
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
     */
    public function __invoke(null $_, array $args): Law
    {
        $file = $args['file'];

        // test

        $tempFilePath = Storage::putFile('temp', $file);
        $xmlFilePath = storage_path('app/' . $tempFilePath);

        return (new LawXmlImport())->import($xmlFilePath);
    }
}
