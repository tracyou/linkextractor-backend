<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\Law\Mutations;

use Illuminate\Http\UploadedFile;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class ImportXmlTest extends AbstractHttpGraphQLTestCase
{
    /** @test */
    public function it_imports_an_xml_file(): void
    {
        $this->multipartGraphQL([
            'query'     => /** @lang GraphQL */ '
                mutation ($file: Upload!) {
                    importXml(file: $file) {
                        title
                    }
                }
            ',
            'variables' => [
                'file' => $this->createUpload('testXml.xml'),
            ],
        ], [
            ['variables.file'],
        ], [
            $this->createUpload('testXml.xml'),
        ])->assertJson([
            'data' => [
                'importXml' => [
                    'title' => 'Aanbestedingswet 2012',
                ],
            ],
        ]);

        $this->assertDatabaseCount('laws', 1);
        $this->assertDatabaseHas('laws', [
            'title' => 'Aanbestedingswet 2012',
        ]);
    }

    /** @test */
    public function it_throws_an_exception_when_invalid_xml_file_is_imported(): void
    {
        $this->multipartGraphQL([
            'query'     => /** @lang GraphQL */ '
                mutation ($file: Upload!) {
                    importXml(file: $file) {
                        title
                    }
                }
            ',
            'variables' => [
                'file' => $this->createUpload('testXml.xml'),
            ],
        ], [
            ['variables.file'],
        ], [
            $this->createUpload('testXmlInvalid.xml'),
        ])->assertGraphQLErrorMessage('invalid xml data');
    }

    protected function createUpload(string $fileName): UploadedFile
    {
        return new UploadedFile(
            storage_path($fileName),
            $fileName,
            'text/xml',
            null,
            true
        );
    }
}
