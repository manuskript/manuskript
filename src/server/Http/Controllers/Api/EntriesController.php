<?php

namespace Manuskript\Http\Controllers\Api;

use Manuskript\Columns\Repository as Columns;
use Manuskript\Entries\Repository as Entries;
use Manuskript\Http\Controllers\Controller;
use Manuskript\Http\Request;
use Manuskript\Http\Resources\Json;

class EntriesController extends Controller
{
    public function index($resource, Columns $columns, Entries $entries, Request $request)
    {
        $query = $entries->only(
            $columns = $columns->fromName($request->field ?? [], $resource, $request)
        )->query($resource);


        if ($order = $columns->filter->order()->first()) {
            $query->orderBy($order->getName(), $order->order());
        }

        $perPage = $resource::perPage();

        $entries = $request->has('ids')
            ? $query->find($request->ids)
            : $query->paginate($request->perPage ?? $perPage->first())->appends($request->query());

        return (new Json\Entries($entries))
            ->fields($request->field ?? [])
            ->additional(compact('columns'));
    }
}
