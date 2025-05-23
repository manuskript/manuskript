<?php

namespace Manuskript\Tests\Entries;

use Illuminate\Database\Eloquent\Model;
use Manuskript\Entries\Adapters\EloquentEntryFactory;
use Manuskript\Entries\Concerns\Context;
use Manuskript\Fields\Concerns\Visibility;
use Manuskript\Fields\Field;
use Manuskript\Resources\Resource;
use Manuskript\Tests\TestCase;

class EloquentEntryFactoryTest extends TestCase
{
    public function testFillResourceFieldsFromResource(): void
    {
        $expectedFields = [
            $this->createMock(Field::class),
            $this->createMock(Field::class),
        ];

        $givenResource = $this->createMock(Resource::class);
        $givenResource->expects($this->once())->method('fields')->willReturn($expectedFields);

        $this->assertSame($expectedFields, $this->sut()->make($givenResource)->fields());
    }

    public function testFillResourceFieldsFromContext(): void
    {
        $givenContext = Context::Index;

        $resourceFields = [
            $this->createMock(Field::class),
            $this->createMock(Field::class),
        ];

        [$expectedField, $otherField] = $resourceFields;
        $expectedField->expects($this->once())->method('visibility')->willReturn(Visibility::Index);

        $givenResource = $this->createMock(Resource::class);
        $givenResource->expects($this->once())->method('fields')->willReturn($resourceFields);

        $this->assertSame([$expectedField], $this->sut()->make($givenResource, context: $givenContext)->fields());
    }

    public function testFillResourceFieldsFromModel(): void
    {
        $fieldName = 'fieldName';
        $fieldValue = 'fieldValue';

        $resourceField = $this->createMock(Field::class);
        $resourceField->expects($this->once())->method('name')->willReturn($fieldName);
        $resourceField->expects($this->once())->method('fill')->with($fieldValue);

        $givenResource = $this->createMock(Resource::class);
        $givenResource->expects($this->once())->method('fields')->willReturn([
            $resourceField
        ]);

        $givenModel = new class () extends Model {};
        $givenModel->$fieldName = $fieldValue;

        $this->sut()->make($givenResource, model:$givenModel);
    }

    private function sut(): EloquentEntryFactory
    {
        return new EloquentEntryFactory();
    }
}
