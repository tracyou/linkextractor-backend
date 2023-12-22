<?php

namespace Tests\Feature;

use App\Enums\MatterRelationEnum;
use App\Factories\AnnotationFactory;
use App\Factories\MatterFactory;
use App\Factories\MatterRelationFactory;
use App\Factories\MatterRelationSchemaFactory;
use App\Factories\RelationSchemaFactory;
use App\Models\MatterRelationSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatterFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testMatterHasManyAnnotations(): void
    {
        $matter = (new MatterFactory())->create("matter", "#000000");
        $relationSchema = (new RelationSchemaFactory())->create(true);
        (new AnnotationFactory())->create(
            schema: $relationSchema,
            matter: $matter,
            text: "this is an annotation"
        );
        $this->assertEquals(1, $matter->annotations->count());
    }

    public function testMatterHasManyRelations(): void
    {
        $matter = (new MatterFactory())->create("matter1", "#000000");
        $relatedMatter = (new MatterFactory())->create("matter2", "#000000");
        $relationSchema = (new RelationSchemaFactory())->create(true);
        $matterRelationSchema = (new MatterRelationSchemaFactory())->create(
            matter: $matter,
            relationSchema: $relationSchema,
            schemaLayout: "{}"
        );
        (new MatterRelationFactory())->create(
            relatedMatter: $relatedMatter,
            schema      : $matterRelationSchema,
            relation    : MatterRelationEnum::REQUIRES_ONE(),
            description : "description",
        );
        $this->assertEquals(1, $matter->matterRelations->count());
        $this->assertInstanceOf(MatterRelationSchema::class, $matter->matterRelations->first()->matterRelationSchema);
    }
}
