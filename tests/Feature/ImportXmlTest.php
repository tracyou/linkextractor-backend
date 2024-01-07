<?php

namespace Feature;

use Tests\TestCase;
use App\Models\Law;
use GraphQL\Error\Error;
use App\Helpers\Import\LawXmlImport;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class ImportXmlTest extends TestCase
{

    use RefreshDatabase;

    public function testImportXmlNotValidPath(): void
    {
        assert($this->assertThrows(fn () => (new LawXmlImport())->import('testXml.xml'), Error::class));
    }

    public function testImportXmlValidPathValidXml(): void
    {
        assert($this->instance(Law::class, (new LawXmlImport())->import(storage_path('testXml.xml'))));
    }

    public function testImportXmlValidPathInvalidXml(): void
    {
        assert($this->instance(Law::class, (new LawXmlImport())->import(storage_path('testXmlInvalid.xml'))));
    }
}
