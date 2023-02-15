<?php

namespace Manuskript\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Manuskript\Http\Request;
use Manuskript\Support\Carbon;

class FileUploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate(['file' => 'file|required']);

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
