<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\Import\LawBookImport;

final class RunXmlImportCommand extends Command
{
    /** @var string $signature */
    protected $signature = 'import:xml';

    /**
     * @var string $description
     */
    protected $description = 'Runs the import XML script';

    public function handle(): void
    {
        $file = storage_path('testXml.xml');

        $xmlString = file_get_contents($file);

        (new LawBookImport())->import($xmlString);
    }
}
