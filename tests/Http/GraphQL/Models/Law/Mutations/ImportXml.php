<?php

namespace Http\GraphQL\Models\Law\Mutations;

use Illuminate\Http\UploadedFile;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class ImportXml extends AbstractHttpGraphQLTestCase
{
    /** @test */
    public function import_xml()
    {

        $file = fopen('tests/Http/GraphQL/Models/Law/Mutations/BWBR0041233_2023-11-01_0.xml', 'BWBR0041233_2023-11-01_0.xml');

       $response = $this->graphQL(/** @lang GraphQL */ '
            mutation ($file: Upload!) {
                importXml(file: $file) {
                    title
                }
            }
        ', [
            'file' => $file ,
        ]);

        dd($response);
//       $response->assertJson(
//           dd($response)
//       );
    }

}
