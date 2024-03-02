<?php

namespace Manuskript\Tests\Fields;

use Illuminate\Database\Eloquent\Model;
use Manuskript\Tests\stubs\Fields\FooField;
use Manuskript\Tests\stubs\Fields\HydratingHookField;
use Manuskript\Tests\stubs\Models\Foo;
use Manuskript\Tests\TestCase;

class FieldTest extends TestCase
{
    public function test_it_is_json_serializable()
    {
        $field = FooField::make('Foo Bar')
            ->default('default value');

        $this->assertEquals([
            'type' => 'foo',
            'name' => 'foo_bar',
            'label' => 'Foo Bar',
            'value' => 'default value',
        ], $field->jsonSerialize());
    }

    public function test_it_can_be_hydrated_from_an_array()
    {
        $field = FooField::make('Foo');
        $this->assertEquals(null, $field->getValue());

        $field->default('foo');
        $this->assertEquals('foo', $field->getValue());

        $field->hydrate(['foo' => 'bar']);
        $this->assertEquals('bar', $field->getValue());
    }

    public function test_it_can_be_hydrated_from_a_model()
    {
        Model::unguard();

        $field = FooField::make('Foo');

        $field->default('foo');
        $this->assertEquals('foo', $field->getValue());

        $field->hydrate(new Foo(['foo' => 'bar']));
        $this->assertEquals('bar', $field->getValue());
    }

    public function test_the_value_may_be_modified_in_hydrating_hook()
    {
        $field = HydratingHookField::make('Foo');

        $field->hydrate(['foo' => 'original value']);
        $this->assertEquals('updated from hook', $field->getValue());
    }

    public function test_it_is_conditional_rendered()
    {
        $field = FooField::make('Foo');

        $this->assertFalse($field->shouldRender('index'));
        $this->assertFalse($field->shouldRender('show'));
        $this->assertFalse($field->shouldRender('create'));
        $this->assertFalse($field->shouldRender('edit'));

        $field->showOnIndex();
        $this->assertTrue($field->shouldRender('index'));

        $field->showOnShow(true);
        $this->assertTrue($field->shouldRender('show'));

        $field->showOnCreate(true)->showOnCreate(false);
        $this->assertFalse($field->shouldRender('create'));

        $field->showOnEdit(fn($request) => true);
        $this->assertTrue($field->shouldRender('edit'));
    }

    public function test_it_is_may_read_only()
    {
        $field = FooField::make('Foo');
        $this->assertFalse($field->getAttribute('readOnly', false));

        $field->readOnly();
        $this->assertTrue($field->getAttribute('readOnly', false));
    }
}
