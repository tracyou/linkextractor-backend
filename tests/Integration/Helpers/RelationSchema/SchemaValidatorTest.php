<?php

declare(strict_types=1);

namespace Integration\Helpers\RelationSchema;

use App\Enums\MatterRelationEnum;
use App\Helpers\RelationSchema\SchemaValidatorInterface;
use App\Models\Article;
use App\Models\Matter;
use App\Models\MatterRelation;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use App\Structs\AnnotationStruct;
use GraphQL\Error\Error;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class SchemaValidatorTest extends AbstractHttpGraphQLTestCase
{
    public SchemaValidatorInterface $validator;

    public function setUp(): void
    {
        parent::setUp();

        $this->validator = $this->app->make(SchemaValidatorInterface::class);

        Matter::factory()->createMany([
            [
                'id'   => $this->createUUIDFromID(1),
                'name' => 'Rechtssubject',
            ],
            [
                'id'   => $this->createUUIDFromID(2),
                'name' => 'Rechtsobject',
            ],
            [
                'id'   => $this->createUUIDFromID(3),
                'name' => 'Rechtsfeit',
            ],
        ]);

        RelationSchema::factory()->create([
            'id'           => $this->createUUIDFromID(1),
            'is_published' => true,
        ]);

        MatterRelationSchema::factory()->create([
            'id'                 => $this->createUUIDFromID(1),
            'matter_id'          => $this->createUUIDFromID(1),
            'relation_schema_id' => $this->createUUIDFromID(1),
        ]);

        MatterRelationSchema::factory()->create([
            'id'                 => $this->createUUIDFromID(2),
            'matter_id'          => $this->createUUIDFromID(2),
            'relation_schema_id' => $this->createUUIDFromID(1),
        ]);

        MatterRelationSchema::factory()->create([
            'id'                 => $this->createUUIDFromID(3),
            'matter_id'          => $this->createUUIDFromID(3),
            'relation_schema_id' => $this->createUUIDFromID(1),
        ]);
    }

    /**
     * @test
     */
    public function it_should_pass_the_validation(): void
    {
        $this->expectNotToPerformAssertions();

        MatterRelation::factory()->create([
            'id'                        => $this->createUUIDFromID(1),
            'related_matter_id'         => $this->createUUIDFromID(2),
            'matter_relation_schema_id' => $this->createUUIDFromID(1),
            'relation'                  => MatterRelationEnum::REQUIRES_ONE(),
        ]);

        MatterRelation::factory()->create([
            'id'                        => $this->createUUIDFromID(2),
            'related_matter_id'         => $this->createUUIDFromID(3),
            'matter_relation_schema_id' => $this->createUUIDFromID(2),
            'relation'                  => MatterRelationEnum::REQUIRES_ONE(),
        ]);

        $this->validator->validate(
            RelationSchema::find($this->createUUIDFromID(1)),
            collect([
                $this->createAnnotation(
                    id      : $this->createUUIDFromID(1),
                    matterId: $this->createUUIDFromID(1)
                ),
                $this->createAnnotation(
                    id      : $this->createUUIDFromID(2),
                    matterId: $this->createUUIDFromID(2)
                ),
                $this->createAnnotation(
                    id      : $this->createUUIDFromID(3),
                    matterId: $this->createUUIDFromID(3)
                ),
            ])
        );
    }

    /**
     * @test
     */
    public function it_should_not_pass_the_validation(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Voorwaarde in het relatieschema: "Rechtsobject requires one Rechtsfeit" wordt niet vervuld in artikel: "Test article"');

        MatterRelation::factory()->create([
            'id'                        => $this->createUUIDFromID(1),
            'related_matter_id'         => $this->createUUIDFromID(2),
            'matter_relation_schema_id' => $this->createUUIDFromID(1),
            'relation'                  => MatterRelationEnum::REQUIRES_ONE(),
        ]);

        MatterRelation::factory()->create([
            'id'                        => $this->createUUIDFromID(2),
            'related_matter_id'         => $this->createUUIDFromID(3),
            'matter_relation_schema_id' => $this->createUUIDFromID(2),
            'relation'                  => MatterRelationEnum::REQUIRES_ONE(),
        ]);

        $this->validator->validate(
            RelationSchema::find($this->createUUIDFromID(1)),
            collect([
                $this->createAnnotation(
                    id      : $this->createUUIDFromID(1),
                    matterId: $this->createUUIDFromID(1)
                ),
                $this->createAnnotation(
                    id      : $this->createUUIDFromID(2),
                    matterId: $this->createUUIDFromID(2)
                ),
                $this->createAnnotation(
                    id      : $this->createUUIDFromID(3),
                    matterId: $this->createUUIDFromID(1)
                ),
            ])
        );
    }

    protected function createAnnotation(string $id, string $matterId): AnnotationStruct
    {
        return new AnnotationStruct(
            tempId    : $id,
            matter    : Matter::find($matterId),
            text      : 'Test text',
            definition: 'Test definition',
            comment   : 'Test comment',
            article   : Article::factory()->create([
                'title' => 'Test article',
            ]),
        );
    }
}
