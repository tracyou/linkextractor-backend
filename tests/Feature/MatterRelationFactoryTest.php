<?php

namespace Tests\Feature;

use App\Factories\MatterFactory;
use App\Factories\MatterRelationFactory;
use App\Models\MatterRelation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatterRelationFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_relation_belongs_to_matters() {
        $matterA = (new MatterFactory)->create("matterA", "#000000");
        $matterB = (new MatterFactory)->create("matterB", "#000000");
        $matterRelation = (new MatterRelationFactory)->create($matterA, $matterB, "requires 1", "description");
        $this->assertEquals($matterA->id, $matterRelation->matter_parent_id);
        $this->assertEquals($matterB->id, $matterRelation->matter_child_id);
    }
}
