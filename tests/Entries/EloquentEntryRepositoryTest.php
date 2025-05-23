<?php

namespace Manuskript\Tests\Entries;

use Illuminate\Database\Eloquent;
use Illuminate\Pagination\CursorPaginator;
use Manuskript\Entries\Adapters\EloquentEntryRepository;
use Manuskript\Entries\Adapters\EloquentEntryFactory;
use Manuskript\Entries\EntryRepository;
use Manuskript\Resources\Resource;
use Manuskript\Tests\TestCase;

class EloquentEntryRepositoryTest extends TestCase
{
    private Eloquent\Model $resourceModel;

    private Eloquent\Builder $queryBuilder;

    private EloquentEntryFactory $entryFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resourceModel = $this->createMock(Eloquent\Model::class);
        $this->queryBuilder = $this->createMock(Eloquent\Builder::class);
        $this->entryFactory = $this->createMock(EloquentEntryFactory::class);
    }

    public function testItFetchesEntriesByResource(): void
    {
        $fetchedModels = [
            $this->createStub(Eloquent\Model::class),
            $this->createStub(Eloquent\Model::class),
        ];

        // Expect paginator has items
        $paginator = $this->createMock(CursorPaginator::class);
        $paginator->expects($this->once())->method('items')
            ->willReturn($fetchedModels);

        // Expect cursor paginated result
        $this->query()
            ->expects($this->once())
            ->method('cursorPaginate')
            ->willReturn($paginator);

        $givenResource = $this->givenResource();

        // Expect EloquentEntryFactory builds collection of two entries
        $this->entryFactory
            ->expects($this->once())
            ->method('collect')
            ->with(
                $givenResource,
                $fetchedModels,
            );

        $this->sut()->collection($givenResource);
    }

    public function testItFetchesEntryByResourceAndKey(): void
    {
        $keyName = 'foo';
        $keyValue = 'bar';

        $fetchedModel = $this->createStub(Eloquent\Model::class);

        // Expect model by its key value
        $queryBuilder = $this->query();
        $queryBuilder
            ->expects($this->once())
            ->method('where')
            ->with($keyName, $keyValue)
            ->willReturn($this->queryBuilder);
        $queryBuilder
            ->expects($this->once())
            ->method('firstOrFail')
            ->willReturn($fetchedModel);

        // Expect key name is resolved from model
        $this->resourceModel
            ->expects($this->once())
            ->method('getKeyName')
            ->willReturn($keyName);

        $givenResource = $this->givenResource();

        // Expect EloquentEntryFactory builds collection of two entries
        $this->entryFactory
            ->expects($this->once())
            ->method('make')
            ->with(
                $givenResource,
                $fetchedModel,
            );

        $this->sut()->find($givenResource, $keyValue);
    }

    private function query(): Eloquent\Builder
    {
        $this->resourceModel->expects($this->once())
            ->method('newQuery')
            ->willReturn($this->queryBuilder);

        return $this->queryBuilder;
    }

    private function givenResource(): Resource
    {
        return new class () extends Resource {
            public string $model = Eloquent\Model::class;
        };
    }

    private function sut(): EloquentEntryRepository|EntryRepository
    {
        return new class ($this->resourceModel, $this->entryFactory) extends EloquentEntryRepository implements EntryRepository {
            private Eloquent\Model $model;

            public function __construct(Eloquent\Model $model, EloquentEntryFactory $entryFactory)
            {
                parent::__construct($entryFactory);
                $this->model = $model;
            }

            protected function model(string $className): Eloquent\Model
            {
                return $this->model;
            }
        };
    }
}
