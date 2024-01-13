<?php

namespace Feature;

use App\Helpers\Import\LawXmlImport;
use App\Models\Law;
use GraphQL\Error\Error;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ImportXmlTest extends TestCase
{
    use RefreshDatabase;

    public function testImportXmlNotValidPath(): void
    {
        $this->assertThrows(fn () => (new LawXmlImport())->import('testXml.xml'), Error::class, 'XML file not found');
    }

    public function testImportXmlValidPathValidXml(): void
    {
        $this->assertInstanceOf(Law::class, (new LawXmlImport())->import(storage_path('testXml.xml')));
    }

    public function testImportXmlValidPathInvalidXml(): void
    {
        $this->assertThrows(fn () => (new LawXmlImport())->import(storage_path('testXmlInvalid.xml')), Error::class, 'invalid xml data');
    }
}
