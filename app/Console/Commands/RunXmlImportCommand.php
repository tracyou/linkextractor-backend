<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\Import\LawXmlImport;
use Illuminate\Console\Command;

/**
 * @codeCoverageIgnore
 */
final class RunXmlImportCommand extends Command
{
    /** @var string */
    protected $signature = 'import:xml {filename=testXml.xml}';

    /** @var string */
    protected $description = 'Runs the import XML script';

    public function handle(): void
    {
        $file = storage_path($this->argument('filename'));

        (new LawXmlImport())->import($file ?: '');
    }
}
