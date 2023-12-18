<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\Import\LawXmlImport;
use Illuminate\Console\Command;

final class RunXmlImportCommand extends Command
{
    /** @var string */
    protected $signature = 'import:xml';

    /** @var string */
    protected $description = 'Runs the import XML script';

    public function handle(): void
    {
        $file = storage_path('testXml.xml');

        $xmlString = file_get_contents($file);

        (new LawXmlImport())->import($xmlString ?: '');
    }
}
