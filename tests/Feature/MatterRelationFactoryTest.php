<?php

namespace Tests\Feature;

use App\Enums\MatterRelationEnum;
use App\Factories\MatterFactory;
use App\Factories\MatterRelationFactory;
use App\Factories\MatterRelationSchemaFactory;
use App\Factories\RelationSchemaFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatterRelationFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationBelongsToMatters()
    {
        $matter = (new MatterFactory())->create("matterA", "#000000");
        $relatedMatter = (new MatterFactory())->create("matterB", "#000000");
        $relationSchema = (new RelationSchemaFactory())->create(true);
        $matterRelationSchema = (new MatterRelationSchemaFactory())->create(
            $matter,
            $relationSchema,
            '{}',
        );
        $matterRelation = (new MatterRelationFactory())->create(
            $relatedMatter,
            $matterRelationSchema,
            MatterRelationEnum::REQUIRES_ONE(),
            "description",
        );
        $this->assertEquals($matter->getKey(), $matterRelation->matterRelationSchema->matter->getKey());
        $this->assertEquals($relatedMatter->getKey(), $matterRelation->relatedMatter->getKey());
    }
}
