<?php

namespace Tests\Http\GraphQL\Models\Law\Queries;

use App\GraphQL\Mutations\DeleteLaw;
use App\Models\Law;
use Illuminate\Validation\ValidationException;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class DeleteLawsTest extends AbstractHttpGraphQLTestCase
{

    /**
     * @throws ValidationException
     */
    public function testDeleteLawMutation(): void
    {
        $law = Law::factory()->create();
        $args = ['id' => $law->id];
        $resolver = new DeleteLaw($law);

        $result = $resolver(null, $args);

        $this->assertTrue($result);
        $this->assertSoftDeleted('laws', ['id' => $law->id]);
    }

    public function testDeleteLawMutationWithNonExistingLawId(): void
    {
        $law = null;
        $args = ['id' => 'non_existing_id'];
        $resolver = new DeleteLaw($law);

        $this->expectException(ValidationException::class);

        $resolver(null, $args);
    }
}
