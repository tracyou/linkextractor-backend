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
        $this->assertThrows(fn () => (new LawXmlImport())->import('testXml.xml'), Error::class);
    }

    public function testImportXmlValidPathValidXml(): void
    {
        $this->assertInstanceOf(Law::class, (new LawXmlImport())->import(storage_path('testXml.xml')));
    }

    public function testImportXmlValidPathInvalidXml(): void
    {
        $this->assertThrows(fn () => (new LawXmlImport())->import('testXmlInvalid.xml'), Error::class);
    }
}
