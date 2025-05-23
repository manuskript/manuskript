<?php

namespace Manuskript\Entries\Adapters;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractCursorPaginator;
use InvalidArgumentException;
use Manuskript\Entries\Concerns\Context;
use Manuskript\Entries\Entry;
use Manuskript\Entries\EntryRepository;
use Manuskript\Resources\Resource;

class EloquentEntryRepository implements EntryRepository
{
    public function __construct(
        private readonly EloquentEntryFactory $entryFactory,
    ) {
    }

    public function collection(Resource $resource, ?Context $context = null, string $cursor = null): CursorPaginator
    {
        return tap(
            $this->model($resource->model)->newQuery()
                ->cursorPaginate(cursor: $cursor),
            fn (AbstractCursorPaginator $paginator) => $paginator->setCollection(
                $this->entryFactory->collect($resource, $paginator->items(), $context)
            ),
        );
    }

    public function find(Resource $resource, string|int $key, ?Context $context = null): Entry
    {
        $model = $this->model($resource->model);
        $result = $model->newQuery()
            ->where($model->getKeyName(), $key)
            ->firstOrFail();

        return $this->entryFactory->make($resource, $result, $context);
    }

    /**
     * @param class-string<Model> $className
     */
    protected function model(string $className): Model
    {
        if (! is_a($className, Model::class, true)) {
            throw new InvalidArgumentException(sprintf(
                'The given class-string: %s must be reference a type of "%s"',
                $className,
                Model::class,
            ));
        }

        return new $className();
    }
}
