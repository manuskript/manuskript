<?php

namespace Manuskript\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Manuskript\Http\Request;
use Manuskript\Http\Resources\Inertia;
use Manuskript\Columns\Repository as Columns;
use Manuskript\Entries\Repository as Entries;

class FileUploadController
{
    public function __invoke(Request $request)
    {
        $file = $request->file('file');

        $disk = Storage::disk($request->disk ?? 'local');

        return  $this->storeFile($disk, $file);
    }

    public function storeFile($disk, $file, $name = null)
    {
        $name ??= $file->getClientOriginalName();

        if ($disk->exists($name)) {
            return $this->storeFile($disk, $file, Carbon::now()->timestamp . $name);
        }

        return $disk->putFileAs('', $file, $name);
    }
}
