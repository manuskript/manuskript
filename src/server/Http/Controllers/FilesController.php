<?php

namespace Manuskript\Http\Controllers;

use Manuskript\Files\Repository as Files;
use Manuskript\Http\Resources\Inertia;

class FilesController extends Controller
{
    public function __construct(protected Files $files)
    {
        parent::__construct();
    }

    public function index($path = null)
    {
        $files = $this->files->files($path);

        return (new Inertia\Files($files))
            ->additional([
                'current' => $path,
                'parent' => $this->files->parent($path),
            ])
            ->view('Files');
    }
}
