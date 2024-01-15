<?php

namespace Tests\Http\GraphQL\Models\FileXml\Queries;

use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class FileXmlsTest extends AbstractHttpGraphQLTestCase
{
    /**
     * @test
     */
    public function it_saves_imported_file(): void
    {
        // Arrange //Act
        $response = $this->graphQL(/** @lang GraphQL */ '
            mutation {
                saveFileXml(input: {
                    title: "this is the file title",
                    content: "this is the file content"
                }) {
                    title,
                    content
                }
            }
        ');

        // Assert
        $response->assertJson([
            'data' => [
                'saveFileXml' => [
                    'title' => 'this is the file title',
                    'content' => 'this is the file content'
                ],
            ],
        ]);


    }

    /**
     * @test
     */
    public function it_gets_all_imported_files()
    {
        // Arrange
        $this->graphQL(/** @lang GraphQL */ '
            mutation {
                saveFileXml(input: {
                    title: "this is the file title",
                    content: "this is the file content"
                }) {
                    title,
                    content
                }
            }
        ');
        $this->graphQL(/** @lang GraphQL */ '
            mutation {
                saveFileXml(input: {
                    title: "this is the file 2 title",
                    content: "this is the file 2 content"
                }) {
                    title,
                    content
                }
            }
        ');

        // Act
        $response = $this->graphQL(/** @lang GraphQL */ '
            query {
                fileXmls{
                    title
                }
            }
        ');

        // Assert
        $response->assertJson([
            'data' => [
                'fileXmls' => [
                    [
                        'title' => 'this is the file title',

                    ],[
                        'title' => 'this is the file 2 title'
                    ]
                ]
            ]
        ]);

    }


}
