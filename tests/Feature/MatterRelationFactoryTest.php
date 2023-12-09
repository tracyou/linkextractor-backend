<?php

namespace Tests\Feature;

use App\Factories\MatterFactory;
use App\Factories\MatterRelationFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatterRelationFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testRelationBelongsToMatters()
    {
        $matterA = (new MatterFactory())->create("matterA", "#000000");
        $matterB = (new MatterFactory())->create("matterB", "#000000");
        $matterRelation = (new MatterRelationFactory())->create($matterA, $matterB, "requires 1", "description");
        $this->assertEquals($matterA->id, $matterRelation->matter_a_id);
        $this->assertEquals($matterB->id, $matterRelation->matter_b_id);
    }
}
