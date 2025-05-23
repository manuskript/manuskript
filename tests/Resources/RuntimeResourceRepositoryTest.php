<?php

namespace Manuskript\Tests\Resources;

use Manuskript\Resources\Adapter\RuntimeResourceRepository;
use Manuskript\Resources\Adapter\RuntimeResourceStorage;
use Manuskript\Resources\Resource;
use Manuskript\Tests\TestCase;

class RuntimeResourceRepositoryTest extends TestCase
{
    public function testFindResourceByKey(): void
    {
        $key = 'result-key';

        $givenStorage = $this->createMock(RuntimeResourceStorage::class);
        $givenStorage->expects($this->once())->method('get')->with($key)->willReturn(
            $this->createStub(Resource::class),
        );

        (new RuntimeResourceRepository($givenStorage))->resolve($key);
    }

    public function testRegisterResource(): void
    {
        $key = 'resource-key';
        $resource = $this->createStub(Resource::class);
        $resource->method('getKey')->willReturn($key);

        $givenStorage = $this->createMock(RuntimeResourceStorage::class);
        $givenStorage->expects($this->once())
            ->method('put')->with($key, $resource);

        (new RuntimeResourceRepository($givenStorage))->register($resource);
    }
}
